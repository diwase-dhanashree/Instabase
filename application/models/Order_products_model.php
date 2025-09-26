<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_products_model extends My_Model {

	const CREATED_AT = NULL;
	const UPDATED_AT = NULL;
	const SOFT_DELETED = NULL;
	
	public $fillables = ["order_id","product_id","points","qty", "size"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'order_id',
				'label' => 'Order Id',
				'rules' => 'trim|required|numeric'
			),
			array(
				'field' => 'product_id',
				'label' => 'Product Id',
				'rules' => 'trim|required|numeric'
			)
		);

		return $rules;
    }
}
