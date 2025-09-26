<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function index()
	{
		$data['stats'] = array(
			'admins' => 0
		);

		$this->load->admin('dashboard', $data);
	}

	public function profile()
    {
    	$this->pageTitle = 'Update Profile';

    	$user = $this->Users
                    ->find()
                    ->where('id', $this->user['id'])
                    ->get()
                    ->row_array();

    	if($this->input->server('REQUEST_METHOD') == 'POST')
        {
        	$user = $this->input->post();

        	$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        	$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_validate_unique_email');
            $this->form_validation->set_message('validate_unique_email', 'The %s is already taken');

            if($user['password'] || $user['repassword'])
            {
            	$this->form_validation->set_rules('password', 'password', 'trim|required');
            	$this->form_validation->set_rules('repassword', 'confirm password', 'trim|required|matches[password]');
            }

            if ($this->form_validation->run())
            {
            	$data = [
            		'first_name' 	=> $user['first_name'],
            		'last_name' 	=> $user['last_name'],
            		'email'			=> $user['email'],
            	];

            	if($user['password'])
                {
                    $data['password'] = $data['repassword'] = md5($user['password']);
                }

                $this->Users->update($data, $this->user['id'], false);

            	$this->session->set_flashdata('success', 'Profile updated successfully.');
            	redirect(admin_url('dashboard'));
            }
            else
            {
            	$this->session->set_flashdata('error', validation_errors());
            }
        }

        $this->load->admin('profile', compact('user'));
    }

    public function validate_unique_email($email)
    {   
        $user = $this->Users->find()->where('email', $email);
        $user->where_not_in('id', $this->user['id']);

        $result = $user->get()->num_rows();

        return $result == 0 ? true : false;
    }
}