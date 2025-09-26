<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends My_Model {

	public $is_new = 0;
	public $fillables = ["first_name","last_name","email","password","role_id"];

	public function rules()
    {
    	$rules = array(
			array(
				'field' => 'first_name',
				'label' => 'First Name',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|callback_validate_unique_email',
				'errors' => array(
					'validate_unique_email' => 'Email address already taken.'
				)
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => $this->is_new ? 'trim|required' : 'trim'
			),
			array(
				'field' => 'repassword',
				'label' => 'Confirm Password',
				'rules' => $this->is_new ? 'trim|required|matches[password]' : 'trim|matches[password]'
			),
			array(
				'field' => 'role_id',
				'label' => 'Role Id',
				'rules' => 'trim|required|numeric'
			)
		);

		return $rules;
    }

    public function is_new($new = 1)
    {
    	$this->is_new = $new;
    }
}