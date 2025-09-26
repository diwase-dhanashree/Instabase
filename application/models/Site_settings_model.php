<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings_model extends My_Model
{
    const SOFT_DELETED = NULL;

    public $fillables = ['logo', 'admin_email', 'terms_conditions', 'login_bg', 'login_banner', 'terms_bg', 'contact_us', 'dashboard_banner'];
}