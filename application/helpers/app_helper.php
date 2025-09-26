<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('dd'))
{
    function dd($array = '')
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit;
    }   
}

if (!function_exists('assets'))
{
    function assets($path = '')
    {
        return base_url('assets/'.$path);
    }   
}

if (!function_exists('admin_url'))
{
    function admin_url($path = '')
    {
        return base_url('admin/'.$path);
    }   
}

if (!function_exists('url'))
{
    function url($path = '')
    {
        return base_url($path);
    }   
}

if (!function_exists('is_admin'))
{
    function is_admin()
    {
        $ci =& get_instance();

        $user = $ci->session->has_userdata('admin_user') ? $ci->session->userdata('admin_user') : '';

        if($user)
        {
            $user = $ci->Users->find()
                        ->where('id', $user['id'])
                        ->where_in('role_id', explode(',', $ci->vars['backend-roles']))
                        ->get()
                        ->row_array();

            if($user)
            {
                return $user;
            }
        }

        return false;
    }   
}

if (!function_exists('current_uid'))
{
    function current_uid()
    {
        $ci =& get_instance();

        $user = $ci->session->has_userdata('admin_user') ? $ci->session->userdata('admin_user') : '';

        if($user)
        {
            $user = $ci->Users->find()
                        ->where('id', $user['id'])
                        ->where_in('role_id', explode(',', $ci->vars['backend-roles']))
                        ->get()
                        ->row_array();

            if($user)
            {
                return $user['id'];
            }
        }

        return false;
    }   
}

if (!function_exists('is_request'))
{
    function is_request($controller = '')
    {
        $ci =& get_instance();

        return strtolower($ci->router->fetch_class()) == strtolower($controller);
    }   
}

if (!function_exists('file_manager'))
{
    function file_manager($field = '')
    {
        return assets('js/filemanager/dialog.php?akey=d357621c8fdb0300fe9db6d81a063a73&type=1&relative_url=1&field_id=' . $field);
    }   
}

if (!function_exists('uploaded_url'))
{
    function uploaded_url($file = '')
    {
        return assets('uploads/' . $file);
    }   
}