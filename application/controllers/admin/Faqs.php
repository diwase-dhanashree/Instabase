<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends Admin_Controller {

    private $dataTableColumns = ["id","question","status","sort_order","created_at"];
    private $dateFields = ["created_at","updated_at"];

    function __construct()
    {
        parent::__construct();

        $this->load->model('Faqs_model', 'Faqs');
        $this->pageTitle = 'Faqs';
    }

    public function index()
    {
        $this->load->admin('faqs/index');
    }

    public function create()
    {
        $row = $this->_save();

        $this->load->admin('faqs/form', compact('row'));
    }

    public function update($id)
    {
        $row = $this->_load($id);

        $row = $this->_save($row);
        
        $this->load->admin('faqs/form', compact('row'));
    }

    public function delete($id)
    {
        $row = $this->_load($id);

        $this->Faqs->delete($id);

        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect(admin_url('faqs'));
    }

    public function datatable()
    {
        $model = $this->Faqs;
        $totalData = $totalFiltered = $model->count();

        $limit = $this->input->post('length');
        $start = $this->input->post('start');

        $order = 'f.' . $this->dataTableColumns[$this->input->post('order[0][column]')];
        $dir = $this->input->post('order[0][dir]');

        $where = array();

        if(!empty($this->input->post('search[value]')))
        {
            $search = $this->input->post('search[value]');
            
            foreach ($this->dataTableColumns as $c)
            {
                if (in_array($c, $this->dateFields))
                {
                    $where[] = 'DATE_FORMAT(f.' . $c . ', "%d-%b-%Y %h:%i%p") LIKE "%' . $search . '%"';
                }
                else
                {
                    $where[] = 'f.' . $c . ' LIKE "%' . $search . '%"';
                }
            }

            $where = '(' . implode(' OR ', $where) . ')';
            $model->setAlias('f')
                    ->find()
                    ->where($where);

            $totalFiltered = $model->count();
        }

        $allData = $model->setAlias('f')
                        ->find()
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
                    elseif(in_array($c, $this->dateFields))
                    {
                        $row[] = date('d-M-Y h:ia', strtotime($d[$c]));
                    }
                    else
                    {
                        $row[] = $d[$c];    
                    }
                }

                $update = admin_url('faqs/update/' . $d['id']);
                $delete = admin_url('faqs/delete/' . $d['id']);

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
        $row = $this->Faqs
                    ->find()
                    ->where('id', $id)
                    ->get()
                    ->row_array();

        if(!$row)
        {
            $this->session->set_flashdata('error', 'Record not found.');
            redirect(admin_url('faqs'));
        }

        return $row;
    }

    private function _save(&$row = array())
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->load->library('form_validation');

            $inputs = $this->input->post();

            if ($this->Faqs->validate($inputs))
            {
                if(isset($row['id']) && $row['id'])
                {
                    $this->Faqs->update($inputs, $row['id'], false);
                }
                else
                {
                    $this->Faqs->insert($inputs, false);
                }

                $this->session->set_flashdata('success', 'Record saved successfully.');
                redirect(admin_url('faqs'));
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
