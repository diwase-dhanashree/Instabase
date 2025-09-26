<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Front_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('Cart_model', 'Cart');
    }

	public function add_to_cart()
	{
        $id = (int) $this->input->post('id');
        $qty = (int) $this->input->post('qty');
        $size = (string) $this->input->post('size');
        $qty = $qty ? $qty : 1;
        
        if($id)
        {
            $cart = $this->Cart
                        ->find()
                        ->where('customer_id', $this->user['id'])
                        ->where('product_id', $id)
                        ->get()
                        ->row_array();

            if(!$cart)
            {
                $this->Cart->insert([
                    'customer_id' => $this->user['id'],
                    'product_id' =>  $id,
                    'qty' => $qty,
                    'size' => $size
                ], false);
            }
        }

        $cart = $this->Cart
                    ->find()
                    ->where('customer_id', $this->user['id'])
                    ->get()
                    ->result_array();
        
        echo count($cart);
    }

    public function remove_from_cart()
	{
        $id = (int) $this->input->post('id');

        if($id)
        {
            $cart = $this->Cart
                        ->find()
                        ->where('customer_id', $this->user['id'])
                        ->where('product_id', $id)
                        ->delete();
        }
        
        $cart = $this->Cart
                    ->find()
                    ->where('customer_id', $this->user['id'])
                    ->get()
                    ->result_array();
        
        echo count($cart);
    }

    public function product_images()
	{
        $this->load->model('Products_model', 'Products');
        $this->load->model('Product_images_model', 'ProductImages');

        $id = (int) $this->input->post('id');
        $images = [];

        $product = $this->Products
                        ->find()
                        ->select('image')
                        ->where('id', $id)
                        ->get()
                        ->row_array();

        if($product && $product['image'])
        {
            $images[] = uploaded_url($product['image']);
        }

        $other_imgs = $this->ProductImages
                            ->find()
                            ->where('product_id', $id)
                            ->get()
                            ->result_array();

        foreach($other_imgs as $i)
        {
            if($i['image'])
            {
                $images[] = uploaded_url($i['image']);
            }
        }

        echo json_encode(['images' => $images]);
        exit;
    }
}

