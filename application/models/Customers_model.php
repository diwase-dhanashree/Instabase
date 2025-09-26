<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends My_Model {

	public $is_new = 1;
	public $fillables = ["email","otp","points"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required'
			)
		);

		return $rules;
    }
}