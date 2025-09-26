<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends My_Model {

	public $fillables = [
		"customer_id","email","first_name","last_name","emp_id",
		"address_1","address_2","address_3","address_4","pincode",
		"contact_number","gender",
		"shiprocket_id","shiprocket_res"
	];

	public function rules()
    {
    	$rules = array();

		return $rules;
    }
}
