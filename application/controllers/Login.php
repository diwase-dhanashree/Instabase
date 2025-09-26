<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index()
	{
        $user = $this->session->has_userdata('front_user') ? $this->session->userdata('front_user') : '';

        if($user)
        {
            $user = $this->Customers->find()
                        ->where('email', $user['email'])
                        ->get()
                        ->row_array();

            if($user)
            {
                redirect(url('home'));
            }
            else
            {
                $this->session->unset_userdata('front_user');
            }
        }

        if($this->input->post('signin'))
        {
            $email = $this->input->post('email');

            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

            if ($this->form_validation->run())
            {
                if(!empty(RESTRICT_DOMAIN)) {
                    $e = explode('@', $email);

                    if(!in_array($e[1], RESTRICT_DOMAIN)) {
                        $this->session->set_flashdata('error', 'You are not allowed to use this email address.');
                        redirect(url('/'));
                    }
                }

                $this->session->set_userdata(array('login_email' => $email));
                redirect(url('/login/terms'));
            }
            else
            {
                $this->session->set_flashdata('error', validation_errors());
            }

            redirect(url('/'));
        }

		$this->load->front_login('login');
	}

    public function terms()
    {
        $user = $this->session->has_userdata('front_user') ? $this->session->userdata('front_user') : [];
        $email = $this->session->has_userdata('login_email') ? $this->session->userdata('login_email') : '';

        if($user)
        {
            redirect(url('/'));
        }
        
        if(!$email)
        {
            redirect(url('/'));
        }

        if($this->input->post('signin'))
        {
            $user = $this->Customers->find()
                    ->where('email', $email)
                    ->get()
                    ->row_array();

            if(!$user)
            {
                $this->Customers->insert(['email' => $email], false);
                $uid = $this->Customers->getLastInsertID();
            }
            else
            {
                $uid = $user['id'];
            }

            $otp = rand(100000, 999999);
            $this->Customers->update(['otp' => $otp], $uid, false);

            $this->load->library('email');
            $email_body = $this->load->email('front/otp', compact('otp'));

            $this->email->from(NO_REPLY_EMAIL, SITE_NAME);
            $this->email->to($email);
            $this->email->subject('Login OTP');
            $this->email->message($email_body);
            $this->email->send();
            // echo $this->email->print_debugger();

            $this->session->set_userdata(array('login_email' => $email));
            redirect(url('/login/otp'));
        }

		$this->load->front_login('terms');
    }

    public function otp()
	{
        $user = $this->session->has_userdata('front_user') ? $this->session->userdata('front_user') : [];
        $email = $this->session->has_userdata('login_email') ? $this->session->userdata('login_email') : '';

        if($user)
        {
            redirect(url('/'));
        }
        
        if($email)
        {
            $user = $this->Customers->find()
                        ->where('email', $email)
                        ->get()
                        ->row_array();
        }

        if(!$user)
        {
            $this->session->unset_userdata('login_email');
            redirect(url('/'));
        }

        if($this->input->post('signin'))
        {
            $otp = $this->input->post('otp');

            if($otp && $otp == $user['otp'])
            {
                $this->session->set_userdata(array('front_user' => $user));
                redirect(url('home'));
            }
            else
            {
                $this->session->set_flashdata('error', 'Invalid OTP.');
                redirect(url('/login/otp'));
            }
        }

		$this->load->front_login('otp', compact('email'));
	}

    public function logout()  
    {  
        $this->session->unset_userdata('front_user');
        $this->session->unset_userdata('login_email');
        $this->session->set_flashdata('success', 'Successfully Logged Out...');
        redirect(url('/'));  
    }
}