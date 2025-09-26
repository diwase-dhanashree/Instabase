<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitesettings extends Admin_Controller {

	public function index()
	{
		$this->pageTitle = 'General Settings';

        $data['settings'] = $this->SiteSettings->find()
                                ->where('id', 1)
                                ->get()
                                ->row_array();

        $this->load->admin('site_settings/index', $data);
	}

	public function store()
	{
        $inputs = $this->input->post();

        $row = $this->SiteSettings->find()
                ->where('id', 1)
                ->get()
                ->row_array();

        if($row)
        {
            $this->SiteSettings->update($inputs, $row['id']);
        }
        else
        {
            $inputs['id'] = 1;
            $this->SiteSettings->insert($inputs);
        }

		$this->session->set_flashdata('success', 'Settings updated successfully.');
		redirect(admin_url('sitesettings'));
	}
}