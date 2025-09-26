<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends Front_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('Product_categories_model', 'Categories');
        $this->load->model('Products_model', 'Products');
        $this->load->model('Cart_model', 'Cart');
        $this->load->model('Orders_model', 'Orders');
        $this->load->model('Order_products_model', 'OrderProducts');
        $this->load->model('Customers_model', 'Customers');
        $this->load->library('shiprocket');
    }

    public function index()
    {
        $this->pageTitle = 'Shopping Cart';

        $order = $this->Orders
            ->find()
            ->select('id')
            ->where('customer_id', $this->user['id'])
            ->get()
            ->result_array();

        if ($order) {
            $cart = [];
        } else {
            $cart = $this->Cart
                ->setAlias('c')
                ->find()
                ->select('p.*, pc.category_id, c.qty')
                ->join('products AS p', 'c.product_id = p.id')
                ->join('product_categories_map AS pc', 'pc.product_id = p.id')
                ->where('c.customer_id', $this->user['id'])
                ->get()
                ->result_array();
        }

        $remaining_cids = [];
        $total_points = 0;

        if($cart) {
            $cats = $this->Categories
                        ->find()
                        ->get()
                        ->result_array();

            $ccids = [];

            foreach($cart as $c) {
                $ccids[$c['category_id']] = $c['category_id'];
                $total_points += ($c['qty'] * $c['price']);
            }

            foreach($cats as $c) {
                if(!in_array($c['id'], $ccids)) {
                    $remaining_cids[] = $c['id'];
                }
            }
        }

        $this->load->front('cart', compact('cart', 'order', 'remaining_cids', 'total_points'));
    }

    public function place_order()
    {
        $order = $this->Orders
            ->find()
            ->select('id')
            ->where('customer_id', $this->user['id'])
            ->get()
            ->result_array();

        if ($order) {
            redirect(url('/cart'));
        }

        $this->load->model('Orders_model', 'Orders');

        $inputs = $this->input->post();

        $cart = $this->Cart
            ->setAlias('c')
            ->find()
            ->select('p.*, c.qty, c.size')
            ->join('products AS p', 'c.product_id = p.id')
            ->where('c.customer_id', $this->user['id'])
            ->get()
            ->result_array();

        $total_points = 0;
        foreach ($cart as $c) {
            $total_points += ($c['qty'] * $c['price']);
        }

        if ($inputs && $cart && $total_points <= $this->user['points']) {
            $inputs['customer_id'] = $this->user['id'];

            $length  = 0;
            $breadth = 0;
            $height  = 0;
            $weight  = 0;

            foreach($cart as $c) {
                $length = $c['length'] > $length ? $c['length'] : $length;
                $breadth = $c['breadth'] > $breadth ? $c['breadth'] : $breadth;
                $height = $c['height'] > $height ? $c['height'] : $height;

                $weight += $c['weight'];
            }

            $this->Orders->insert($inputs, false);
            $order_id = $this->Orders->getLastInsertID();

            foreach ($cart as $c) {
                $product_data = [
                    'order_id'   => $order_id,
                    'product_id' => $c['id'],
                    'points'     => $c['price'],
                    'qty'        => $c['qty'],
                    'size'        => $c['size'],
                ];

                $this->OrderProducts->insert($product_data, false);
            }

            $remaining_points = $this->user['points'] - $total_points;
            $this->Customers->update(['points' => $remaining_points], $this->user['id'], false);

            $this->Cart
                ->find()
                ->where('customer_id', $this->user['id'])
                ->delete();

            $order = $this->Orders
                ->find()
                ->where('id', $order_id)
                ->get()
                ->row_array();

            $sr_data = [
                "order_id" => SHIPROCKER_PREFIX . $order['id'],
                "order_date" => $order['created_at'],
                "pickup_location" => "Primary",
                "channel_id" => "",
                "comment" => "",
                "billing_customer_name" => $inputs['first_name'],
                "billing_last_name" => $inputs['last_name'],
                "billing_address" => $inputs['address_1'],
                "billing_address_2" => $inputs['address_2'],
                "billing_city" => $inputs['address_3'],
                "billing_state" => $inputs['address_4'],
                "billing_pincode" => $inputs['pincode'],
                "billing_country" => "India",
                "billing_email" => $inputs['email'],
                "billing_phone" => $inputs['contact_number'],
                "shipping_is_billing" => true,
                "shipping_customer_name" => "",
                "shipping_last_name" => "",
                "shipping_address" => "",
                "shipping_address_2" => "",
                "shipping_city" => "",
                "shipping_pincode" => "",
                "shipping_country" => "",
                "shipping_state" => "",
                "shipping_email" => "",
                "shipping_phone" => "",
                "order_items" => [],
                "payment_method" => "Prepaid",
                "shipping_charges" => 0,
                "giftwrap_charges" => 0,
                "transaction_charges" => 0,
                "total_discount" => 0,
                "sub_total" => 0,
                "length" => $length ? $length : 10,
                "breadth" => $breadth ? $breadth : 15,
                "height" => $height ? $height : 20,
                "weight" => $weight ? $weight : 1
            ];

            foreach ($cart as $c) {
                $sr_data['order_items'][] = [
                    "name" => $c['name'],
                    "sku" => "product-" . $c['id'],
                    "units" => $c['qty'],
                    "selling_price" => "0",
                    "discount" => "",
                    "tax" => "",
                    "hsn" => $c['id']
                ];
            }

            $sr_res = $this->shiprocket->create_order($sr_data);

            $update_data = [
                'shiprocket_res' => json_encode($sr_res),
                'shiprocket_id' => empty($sr_res->shipment_id) ? '' : $sr_res->shipment_id
            ];

            $this->Orders->update($update_data, $order_id, false);
            
            $this->load->library('email');
            $email_body = $this->load->email('front/order', compact('inputs', 'cart'));

            $this->email->from(NO_REPLY_EMAIL, SITE_NAME);
            $this->email->to($inputs['email']);
            $this->email->subject('Order Confirmation');
            $this->email->message($email_body);
            $this->email->send();

            redirect(url('/cart/thankyou'));
        }

        redirect(url('/cart'));
    }

    public function thankyou()
    {
        $this->pageTitle = 'Order Placed';

        $this->load->front('thankyou');
    }

    public function track_order()
    {
        $this->pageTitle = 'Track Order';

        $order = $this->Orders
            ->find()
            ->where('customer_id', $this->user['id'])
            ->get()
            ->row_array();

        if (!$order) {
            redirect(url('/cart'));
        }

        $products = $this->OrderProducts
                ->setAlias('op')
                ->find()
                ->select('p.*, op.qty')
                ->join('products AS p', 'op.product_id = p.id')
                ->where('op.order_id', $order['id'])
                ->get()
                ->result_array();

        $sr_res = $this->shiprocket->track_order($order['shiprocket_id']);

        if(!$sr_res) {
            $sr_oid = json_decode($order['shiprocket_res']);
            
            if(isset($sr_oid->order_id)) {
                $details = $this->shiprocket->order_details($sr_oid->order_id);

                if($details) {
                    $sr_res = [
                        'tracking_data' => [
                            'shipment_track_activities' => [
                                [
                                    'date' => $details->data->updated_at,
                                    'activity' => $details->data->status
                                ]
                            ]
                        ]
                    ];

                    $sr_res = json_decode(json_encode($sr_res));
                }
            }
        }

        $this->load->front('trackorder', compact('order', 'products', 'sr_res'));
    }
}
