<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productcategories extends Admin_Controller {

    private $dataTableColumns = ["id","name","created_at"];
    private $dateFields = ["created_at","updated_at"];

    function __construct()
    {
        parent::__construct();

        $this->load->model('Product_categories_model', 'Product_categories');
        $this->pageTitle = 'Product Categories';
    }

    public function index()
    {
        $this->load->admin('product_categories/index');
    }

    public function create()
    {
        $row = $this->_save();

        $categories = $this->categories();

        $this->load->admin('product_categories/form', compact('row', 'categories'));
    }

    public function update($id)
    {
        $row = $this->_load($id);

        $row = $this->_save($row);
        
        $categories = $this->categories();

        if(isset($categories[$id]))
        {
            unset($categories[$id]);
        }

        $this->load->admin('product_categories/form', compact('row', 'categories'));
    }

    public function delete($id)
    {
        $row = $this->_load($id);

        $this->Product_categories->delete($id);

        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect(admin_url('productcategories'));
    }

    public function datatable()
    {
        $model = $this->Product_categories->find();
        $totalData = $totalFiltered = $this->Product_categories->count();
        $model = $this->Product_categories;

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

                $update = admin_url('productcategories/update/' . $d['id']);
                $delete = admin_url('productcategories/delete/' . $d['id']);

                $actions = "<div class='btn-group'>";
                
                if($update)
                {
                    $actions .= "  <a href='{$update}' class='btn btn-primary btn-sm' title='Edit'><i class='fa fa-pencil'></i></a>";
                }

                if($delete)
                {
                    $actions .= "  <a href='{$delete}' class='btn btn-danger btn-sm' title='Delete' onclick='return confirm(\"Are you sure you want to delete this?\")'><i class='fa fa-trash'></i></button>";
                }

                $actions .= "</div>";

                $row[] = ($update || $delete) ? $actions : '';
                
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
        $row = $this->Product_categories
                    ->find()
                    ->where('id', $id)
                    ->get()
                    ->row_array();

        if(!$row)
        {
            $this->session->set_flashdata('error', 'Record not found.');
            redirect(admin_url('productcategories'));
        }

        return $row;
    }

    private function _save(&$row = array())
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->load->library('form_validation');

            $inputs = $this->input->post();

            if ($this->Product_categories->validate($inputs))
            {
                if(isset($row['id']) && $row['id'])
                {
                    $this->Product_categories->update($inputs, $row['id'], false);
                }
                else
                {
                    $this->Product_categories->insert($inputs, false);
                }

                $this->session->set_flashdata('success', 'Record saved successfully.');
                redirect(admin_url('productcategories'));
            }
            else
            {
                $row = array_merge($row, $inputs);
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        return $row;
    }

    private function categories(&$array = [], $parent_id = 0, $dept = 0)
    {
        $where = $parent_id ? 'parent_id = ' . $parent_id : 'parent_id IS NULL OR parent_id = 0';

        $cats = $this->Product_categories
                    ->find()
                    ->where($where)
                    ->get()
                    ->result_array();

        foreach ($cats as $c)
        {
            $pad = str_pad('', $dept, '-', STR_PAD_LEFT);
            $pad = $pad ? $pad . ' ' : '';

            $array[$c['id']] = $pad . $c['name'];

            if($dept < 1)
            {
                // $this->categories($array, $c['id'], ($dept+1));
            }
        }

        return $array;
    }
}
