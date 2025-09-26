<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	var $vars;

    function __construct()
    {
        parent::__construct();

        // Settings Settings & Variables
        $site = $this->SiteSettings->findOne(1);

        $params = array();

        if($site)
        {
        	$site = $site->toArray();

			unset($site->id);
			unset($site->created_at);
			unset($site->updated_at);

            $params['site'] = $site;
        }

        $this->vars = $params;
        $this->vars['backend-roles'] = '1';
    }
}

class Admin_Controller extends MY_Controller {

    var $pageTitle = '';
    var $user;
    var $permissions = array();

    function __construct()
    {
        parent::__construct();

        // Check for admin 
        $is_admin = false;
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
                $is_admin = true;
                $this->user = $user;
            }
        }

        if(!$is_admin)
        {
            $this->session->unset_userdata('admin_user');
            redirect(url('adminpanel'));
        }
    }
}

class Front_Controller extends MY_Controller {

    var $pageTitle = '';
    var $user;

    function __construct()
    {
        parent::__construct();

        // Check for logged user 
        $is_logged = false;
        $user = $this->session->has_userdata('front_user') ? $this->session->userdata('front_user') : '';

        if($user)
        {
            $user = $this->Customers->find()
                        ->where('id', $user['id'])
                        ->get()
                        ->row_array();

            if($user)
            {
                $is_logged = true;

                $now = time();
                $created = strtotime($user['created_at']);
                $diff = ceil(($now - $created) / (60 * 60 * 24));

                if($diff >= 365) {
                    $user['points'] = 0;
                }

                $this->user = $user;
            }
        }

        if(!$is_logged)
        {
            $this->session->unset_userdata('front_user');
            redirect(url('/'));
        }
    }
}