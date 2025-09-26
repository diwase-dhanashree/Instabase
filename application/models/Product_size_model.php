<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_size_model extends My_Model {

	public $fillables = ["size"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'size',
				'label' => 'Size',
				'rules' => 'trim|required'
			),
		);

		return $rules;
    }
}
