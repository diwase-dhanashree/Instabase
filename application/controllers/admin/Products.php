<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller {

    private $dataTableColumns = ["id", "name", "price", "status", "created_at"];
    private $dateFields = ["created_at","updated_at"];

    function __construct()
    {
        parent::__construct();

        $this->load->model('Products_model', 'Products');
        $this->load->model('Product_categories_map_model', 'ProductCategories');
        $this->load->model('Product_categories_model', 'Categories');
        $this->load->model('Product_images_model', 'ProductImages');

        $this->pageTitle = 'Products';
    }

    public function index()
    {
        $this->load->admin('products/index');
    }

    public function create()
    {
        $row = $this->_save();

        $categories = $this->categories();
        
        $this->load->admin('products/form', compact('row', 'categories'));
    }

    public function update($id)
    {
        $row = $this->_load($id);

        $row = $this->_save($row);

        $product_cats = $this->ProductCategories
                                ->find()
                                ->where('product_id', $id)
                                ->get()
                                ->result_array();

        $row['categories'] = [];
        foreach ($product_cats as $pc)
        {
            $row['categories'][] = $pc['category_id'];
        }

        $row['images'] = $this->ProductImages
                                ->find()
                                ->where('product_id', $id)
                                ->get()
                                ->result_array();

        $categories = $this->categories();
        
        $this->load->admin('products/form', compact('row', 'categories'));
    }

    public function delete($id)
    {
        $row = $this->_load($id);

        $this->Products->delete($id);

        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect(admin_url('products'));
    }

    public function datatable()
    {
        $model = $this->Products->find();
        $totalData = $totalFiltered = $this->Products->count();
        $model = $this->Products;

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
                    if($c == 'status')
                    {
                        $row[] = $d[$c] ? 'Active' : 'Inactive';
                    }
                    elseif($c == 'price')
                    {
                        $row[] = number_format($d[$c]);
                    }
                    elseif(in_array($c, $this->dateFields))
                    {
                        $row[] = date('d-M-Y h:ia', strtotime($d[$c]));
                    }
                    else
                    {
                        $row[] = $d[$c];
                    }
                }

                $update = admin_url('products/update/' . $d['id']);
                $delete = admin_url('products/delete/' . $d['id']);

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
        $row = $this->Products
                    ->find()
                    ->where('id', $id)
                    ->get()
                    ->row_array();

        if(!$row)
        {
            $this->session->set_flashdata('error', 'Record not found.');
            redirect(admin_url('products'));
        }

        return $row;
    }

    private function _save(&$row = array())
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->load->library('form_validation');

            $inputs = $this->input->post();
            $categories = isset($inputs['categories']) ? $inputs['categories'] : array();
            $images     = isset($inputs['images']) ? $inputs['images'] : array();

            if ($this->Products->validate($inputs))
            {
                if(isset($row['id']) && $row['id'])
                {
                    $this->Products->update($inputs, $row['id'], false);
                    $p_id = $row['id'];
                }
                else
                {
                    $this->Products->insert($inputs, false);
                    $row['id'] = $p_id = $this->Products->getLastInsertID();
                }

                // Categories
                $cids = [0];
                foreach ($categories as $c)
                {
                    $val = $this->ProductCategories
                                    ->find()
                                    ->where('product_id', $row['id'])
                                    ->where('category_id', $c)
                                    ->get()
                                    ->row_array();

                    if($val)
                    {
                        $cids[] = $val['id'];
                    }
                    else
                    {
                        $this->ProductCategories->insert([
                            'product_id'  => $row['id'],
                            'category_id' => $c
                        ], false);

                        $cids[] = $this->ProductCategories->getLastInsertID();
                    }
                }

                $this->ProductCategories
                    ->find()
                    ->where('product_id', $row['id'])
                    ->where_not_in('id', $cids)
                    ->delete();

                // Images
                $iids = [0];
                foreach ($images as $v)
                {
                    $v['id'] = isset($v['id']) ? (int) $v['id'] : 0;
                    $v['product_id'] = $row['id'];
                    
                    $val = $this->ProductImages
                                    ->find()
                                    ->where('id', $v['id'])
                                    ->get()
                                    ->row_array();

                    if($val)
                    {
                        $this->ProductImages->update($v, $v['id'], false);
                    }
                    else
                    {
                        unset($v['id']);
                        $this->ProductImages->insert($v, false);
                        $val['id'] = $this->ProductImages->getLastInsertID();
                    }

                    $iids[] = $val['id'];
                }

                $this->ProductImages
                    ->find()
                    ->where('product_id', $row['id'])
                    ->where_not_in('id', $iids)
                    ->delete();

                $this->session->set_flashdata('success', 'Record saved successfully.');
                redirect(admin_url('products'));
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

        $cats = $this->Categories
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
                $this->categories($array, $c['id'], ($dept+1));
            }
        }

        return $array;
    }
}
