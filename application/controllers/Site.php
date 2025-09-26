<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends Front_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('Product_categories_model', 'Categories');
        $this->load->model('Products_model', 'Products');
        $this->load->model('Cart_model', 'Cart');
        $this->load->model('Orders_model', 'Orders');
        $this->load->model('Product_size_model', 'Size');
    }

	public function home()
	{
        $this->pageTitle = 'Welcome';

        $this->load->front('home');
    }

    public function category()
    {
        $id = (int) $this->uri->segment(2);
        $cartAllowed = true;
        $cpid = [];
        $qtys = [];

        $category = $this->Categories
                        ->find()
                        ->where('id', $id)
                        ->get()
                        ->row_array();

        if(!$category) 
        {
            redirect(url('home'));
        }

        $products = $this->Products
                        ->setAlias('p')
                        ->find()
                        ->select('p.id, p.name, p.image, p.price, p.link')
                        ->join('product_categories_map AS c', 'c.product_id = p.id')
                        ->where('c.category_id', $id)
                        ->where('status', 1)
                        ->order_by('p.id', 'desc')
                        ->get()
                        ->result_array();
        
        $order = $this->Orders
                        ->find()
                        ->select('id')
                        ->where('customer_id', $this->user['id'])
                        ->get()
                        ->result_array();
        $size = $this->Size
                        ->find()
                        ->select('id, size')
                        ->get()
                        ->result_array();

        if($order)
        {
            $cartAllowed = false;
        }
        else
        {
            $cart = $this->Cart
                        ->setAlias('c')
                        ->find()
                        ->select('c.product_id, c.qty')
                        ->join('products AS p', 'c.product_id = p.id')
                        ->join('product_categories_map AS pc', 'pc.product_id = p.id')
                        ->where('pc.category_id', $id)
                        ->where('c.customer_id', $this->user['id'])
                        ->get()
                        ->result_array();


            foreach($cart as $c)
            {
                $cpid[] = $c['product_id'];
                $qtys[$c['product_id']] = $c['qty'];
            }
        }
        
        $this->pageTitle = $category['name'];
        $this->load->front('category', compact('category', 'products', 'cpid', 'cartAllowed', 'qtys', 'size'));
    }

    public function faqs()
    {
        $this->load->model('Faqs_model', 'Faqs');

        $faqs = $this->Faqs
                    ->find()
                    ->where('status', 1)
                    ->order_by('sort_order', 'asc')
                    ->get()
                    ->result_array();

        $this->pageTitle = 'FAQs';

        $this->load->front('faqs', compact('faqs'));
    }

    public function contact()
	{
        $this->pageTitle = 'Contact Us';

        $this->load->front('contact');
    }
}

