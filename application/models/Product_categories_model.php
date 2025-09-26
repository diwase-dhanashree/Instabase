<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_categories_model extends My_Model {

    public $fillables = ["name","parent_id", "is_size_view"];

    public function rules()
    {
        $rules = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            )
        );

        return $rules;
    }
}
