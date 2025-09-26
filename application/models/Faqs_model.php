<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs_model extends My_Model {

	public $fillables = ["question","answer","status","sort_order"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'question',
				'label' => 'Question',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'answer',
				'label' => 'Answer',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'trim|required|numeric'
			)
		);

		return $rules;
    }
}
