<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

    public function admin_login($template_name, $vars = array())
    {
        $vars['body'] = $this->view('admin/' . $template_name, $vars, true);
        $this->view('layouts/admin_login', $vars);
    }

	public function admin($template_name, $vars = array())
    {
    	$vars['header'] = $this->view('layouts/includes/admin/header', array(), true);
    	$vars['sidebar'] = $this->view('layouts/includes/admin/sidebar', array(), true);
        $vars['body'] = $this->view('admin/' . $template_name, $vars, true);

        $this->view('layouts/admin', $vars);
    }

    public function front_login($template_name, $vars = array())
    {
        $vars['body'] = $this->view('front/' . $template_name, $vars, true);
        $this->view('layouts/front_login', $vars);
    }

    public function front($template_name, $vars = array())
    {
    	$vars['header'] = $this->view('layouts/includes/front/header', array(), true);
        $vars['sidebar'] = $this->view('layouts/includes/front/sidebar', array(), true);
        $vars['body'] = $this->view('front/' . $template_name, $vars, true);

        $this->view('layouts/front', $vars);
    }
    
    public function email($template_name, $vars = array())
    {
        return $this->view('emails/' . $template_name, $vars, true);
    }
}