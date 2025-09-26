<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends My_Model
{
    const SOFT_DELETED = NULL;

    public $fillables = ['customer_id', 'product_id', 'qty', 'size'];
}