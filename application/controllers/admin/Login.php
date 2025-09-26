<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index()
	{
        $user = $this->session->has_userdata('admin_user') ? $this->session->userdata('admin_user') : '';

        if($user)
        {
            $user = $this->Users->find()
                        ->where('id', $user['id'])
                        ->where_in('role_id', explode(',', $this->vars['backend-roles']))
                        ->get()
                        ->row_array();

            if($user)
            {
                redirect(admin_url('dashboard'));
            }
            else
            {
                $this->session->unset_userdata('admin_user');
            }
        }

        if($this->input->post('signin'))
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'trim|required');

            if ($this->form_validation->run())
            {
                $user = $this->Users->find()
                        ->where('email', $email)
                        ->where('password', MD5($password))
                        ->where_in('role_id', explode(',', $this->vars['backend-roles']))
                        ->get()
                        ->row_array();

                if($user)
                {
                    $this->session->set_userdata(array('admin_user' => $user));
                    redirect(admin_url('dashboard'));
                }
                else
                {
                    $this->session->set_flashdata('error', 'Invalid Email/Password.');
                }
            }
            else
            {
                $this->session->set_flashdata('error', validation_errors());
            }

            redirect(url('adminpanel'));
        }

		$this->load->admin_login('login');
	}

    public function logout()  
    {  
        $this->session->unset_userdata('admin_user');
        $this->session->set_flashdata('success', 'Successfully Logged Out...');
        redirect(url('adminpanel'));  
    }
}