<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends Admin_Controller {

    private $dataTableColumns = ["id","email","points","ordered"];
    private $dateFields = ["created_at","updated_at"];

    function __construct()
    {
        parent::__construct();

        $this->load->model('Customers_model', 'Customers');
        $this->pageTitle = 'Customers';
    }

    public function index()
    {
        $this->load->admin('customers/index');
    }

    public function update($id)
    {
        $row = $this->_load($id);

        $row = $this->_save($row);
        
        $this->load->admin('customers/form', compact('row'));
    }
	
	public function export()
    {
        $where = $this->input->get('ordered') == '1' ? 'o.id IS NOT NULL' : 'o.id IS NULL';

        $data = $this->Customers
                    ->setAlias('c')
                    ->find()
                    ->select('c.email, (CASE WHEN o.id THEN "Yes" ELSE "No" END) AS ordered')
                    ->join('orders AS o', 'o.customer_id = c.id', 'left')
                    ->where($where)
                    ->get()
                    ->result_array();

        $f = fopen('php://memory', 'w'); 
        fputcsv($f, ['Email', 'Order Placed']); 
        foreach ($data as $d) { 
            fputcsv($f, $d); 
        }
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="customer.csv";');
        fpassthru($f);
        exit;
    }

    public function datatable()
    {   
        $model = $this->Customers->find();
        $totalData = $totalFiltered = $this->Customers->count();
        $model = $this->Customers;

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
                if($c == 'ordered')
                {
                    $where[] = '(CASE WHEN o.id THEN "Yes" ELSE "No" END) LIKE "%' . $search . '%"';
                }
                else if (in_array($c, $this->dateFields))
                {
                    $where[] = 'DATE_FORMAT(c.' . $c . ', "%d-%b-%Y %h:%i%p") LIKE "%' . $search . '%"';
                }
                else
                {
                    $where[] = 'c.' . $c . ' LIKE "%' . $search . '%"';
                }
            }

            $where = '(' . implode(' OR ', $where) . ')';
            $model->setAlias('c')
                    ->find()
                    ->join('orders AS o', 'o.customer_id = c.id', 'left')
                    ->where($where);

            $totalFiltered = $model->count();
        }

        $allData = $model->setAlias('c')
                        ->find()
                        ->select('c.*, (CASE WHEN o.id THEN "Yes" ELSE "No" END) AS ordered')
                        ->join('orders AS o', 'o.customer_id = c.id', 'left')
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
                    if($c == 'points')
                    {
                        $row[] = number_format($d[$c]);
                    }
                    elseif(in_array($c, $this->dateFields))
                    {
                        $row[] =  date('d-M-Y h:ia', strtotime($d[$c]));
                    }
                    else
                    {
                        $row[] = $d[$c];    
                    }
                }

                $update = admin_url('customers/update/' . $d['id']);

                $actions = "<div class='btn-group'>";

                if($update)
                {
                    $actions .= "  <a href='{$update}' class='btn btn-primary btn-sm' title='Edit'><i class='fa fa-pencil'></i></a>";
                }

                $actions .= "</div>";

                $row[] = ($update) ? $actions : '';
                
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
        $row = $this->Customers
                    ->find()
                    ->where('id', $id)
                    ->get()
                    ->row_array();

        if(!$row)
        {
            $this->session->set_flashdata('error', 'Record not found.');
            redirect(admin_url('customers'));
        }

        return $row;
    }

    private function _save(&$row = array())
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->load->library('form_validation');

            $inputs = $this->input->post();

            if ($this->Customers->validate($inputs))
            {
                $this->Customers->update($inputs, $row['id'], false);

                $this->session->set_flashdata('success', 'Record saved successfully.');
                redirect(admin_url('customers'));
            }
            else
            {
                $row = array_merge($row, $inputs);
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        return $row;
    }
}
