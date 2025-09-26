<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller {

    private $dataTableColumns = ["id", "first_name", "last_name", "email", "emp_id", "created_at"];
    private $dateFields = ["created_at","updated_at"];

    function __construct()
    {
        parent::__construct();

        $this->load->model('Orders_model', 'Orders');
        $this->load->model('Order_products_model', 'OrderProducts');

        $this->pageTitle = 'Orders';
    }

    public function index()
    {
        $this->load->admin('orders/index');
    }

    public function view($id)
    {
        $order = $this->_load($id);
        $this->load->library('shiprocket');

        $products = $this->OrderProducts
                        ->setAlias('op')
                        ->find()
                        ->select('p.*, op.qty')
                        ->join('products AS p', 'op.product_id = p.id')
                        ->where('order_id', $id)
                        ->get()
                        ->result_array();

        $tracking = $this->shiprocket->track_order($order['shiprocket_id']);

        if(!$tracking) {
            $sr_oid = json_decode($order['shiprocket_res']);
            
            if(isset($sr_oid->order_id)) {
                $details = $this->shiprocket->order_details($sr_oid->order_id);

                if($details) {
                    $tracking = [
                        'tracking_data' => [
                            'shipment_track_activities' => [
                                [
                                    'date' => $details->data->updated_at,
                                    'activity' => $details->data->status
                                ]
                            ]
                        ]
                    ];

                    $tracking = json_decode(json_encode($tracking));
                }
            }
        }

        $this->load->admin('orders/view', compact('order', 'products', 'tracking'));
    }

    public function export()
    {
        $orders = $this->Orders
                        ->setAlias('o')
                        ->find()
                        ->select('o.*, GROUP_CONCAT(p.name SEPARATOR " | ") as products, GROUP_CONCAT(op.size SEPARATOR " | ") as sizes')
                        ->join('order_products AS op', 'op.order_id = o.id')
                        ->join('products AS p', 'op.product_id = p.id')
                        ->group_by('o.id')
                        ->get()
                        ->result_array();

        $f = fopen('php://memory', 'w'); 
        

        fputcsv($f, ['Order ID', 'Email', 'First Name', 'Last Name', 'Employee ID', 'Address 1', 'Address 2', 'Address 3', 'Address 4',  'Pin Code', 'Contact Number', 'Gender', 'Date', 'Products', 'Size']); 

        foreach ($orders as $o)
        { 
            unset($o['shiprocket_id']);
            unset($o['shiprocket_res']);
            unset($o['customer_id']);
            unset($o['deleted']);
            unset($o['updated_at']);

            fputcsv($f, $o); 
        }

        fseek($f, 0);

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="orders.csv";');

        fpassthru($f);
        exit;
    }

    public function datatable()
    {
        $model = $this->Orders->find();
        $totalData = $totalFiltered = $this->Orders->count();
        $model = $this->Orders;

        $limit = $this->input->post('length');
        $start = $this->input->post('start');

        $order = $this->dataTableColumns[$this->input->post('order[0][column]')];
        $dir = $this->input->post('order[0][dir]');

        $where = array();

        if(!empty($this->input->post('search[value]')))
        {
            $search = $this->input->post('search[value]');
            
            foreach ($this->dataTableColumns as $c)
            {
                if (in_array($c, $this->dateFields))
                {
                    $where[] = 'DATE_FORMAT(' . $c . ', "%d-%b-%Y %h:%i%p") LIKE "%' . $search . '%"';
                }
                else
                {
                    $where[] = $c . ' LIKE "%' . $search . '%"';
                }
            }

            $where = '(' . implode(' OR ', $where) . ')';
            $model->find()->where($where);

            $totalFiltered = $model->count();
        }

        $allData = $model->find()
                        ->where($where)
                        ->limit($limit, $start)
                        ->order_by($order, $dir)
                        ->get()
                        ->result_array();

        $data = array();

        if(!empty($allData))
        {
            foreach ($allData as $d)
            {
                $row = [];
                foreach($this->dataTableColumns as $c)
                {
                    $row[] = in_array($c, $this->dateFields) ? date('d-M-Y h:ia', strtotime($d[$c])) : $d[$c];
                }

                $view = admin_url('orders/view/' . $d['id']);

                $actions = "<div class='btn-group'>";
                
                if($view)
                {
                    $actions .= "  <a href='{$view}' class='btn btn-default btn-sm' title='View'><i class='fa fa-eye'></i></a>";
                }

                $actions .= "</div>";

                $row[] = $view ? $actions : '';
                
                $data[] = $row;
            }
        }

        $json_data = array(
            'draw'            => intval($this->input->post('draw')),
            'recordsTotal'    => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $data
        );

        echo json_encode($json_data);
        exit;
    }

    private function _load($id)
    {
        $row = $this->Orders
                    ->find()
                    ->where('id', $id)
                    ->get()
                    ->row_array();

        if(!$row)
        {
            $this->session->set_flashdata('error', 'Record not found.');
            redirect(admin_url('orders'));
        }

        return $row;
    }
}
