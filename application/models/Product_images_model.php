<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_images_model extends My_Model {

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
    const SOFT_DELETED = NULL;

    public $fillables = ["product_id","image"];

    public function rules()
    {
        $rules = array(
            array(
                'field' => 'product_id',
                'label' => 'Product',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'image',
                'label' => 'Image',
                'rules' => 'trim|required'
            )
        );

        return $rules;
    }
}
