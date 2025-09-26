<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends My_Model {

	public $fillables = ["name","image","price","status","link", "length", "breadth", "height", "weight"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'image',
				'label' => 'Image',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'price',
				'label' => 'Price',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'length',
				'label' => 'Length',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'breadth',
				'label' => 'Breadth',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'height',
				'label' => 'Height',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'weight',
				'label' => 'Weight',
				'rules' => 'trim|required'
			)
		);

		return $rules;
    }
}
