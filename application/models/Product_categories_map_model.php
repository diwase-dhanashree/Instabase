<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_categories_map_model extends My_Model {

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
    const SOFT_DELETED = NULL;

    public $fillables = ["product_id","category_id"];

    public function rules()
    {
        $rules = array(
            array(
                'field' => 'product_id',
                'label' => 'Blog',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'category_id',
                'label' => 'Category',
                'rules' => 'trim|required'
            )
        );

        return $rules;
    }
}
