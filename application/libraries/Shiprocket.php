<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shiprocket {

    public function create_order($data)
    {
        return $this->curl_request('/orders/create/adhoc', $data);
    }

    public function create_forward_shipment($data)
    {
        return $this->curl_request('/shipments/create/forward-shipment', $data);
    }

    public function cancel_order($id)
    {
        $res = $this->curl_request('/orders/cancel', ['ids' => [$id]]);

        dd($res);
    }

    public function track_shipment($id)
    {
        return $this->curl_request('/courier/track/shipment/' . $id);
    }

    public function track_order($id)
    {
        return $this->curl_request('/courier/track?order_id=' . $id);
    }

    public function order_details($id)
    {
        return $this->curl_request('/orders/show/' . $id);
    }

    private function authenticate()
    {
        $res = $this->curl_request('/auth/login', ['email' => SHIPROCKET_EMAIL, 'password' => SHIPROCKET_PASSWORD], false);

        return !empty($res->token) ? $res->token : '';
    }

    private function curl_request($endpoint, $data = [], $token_required = true)
    {
        $url = 'https://apiv2.shiprocket.in/v1/external' . $endpoint;

        $headers = array(
            'Content-Type:application/json'
        );

        if($token_required) {
            $token = $this->authenticate();

            if(!$token) {
                return false;
            }

            $headers[] = 'Authorization: Bearer ' . $token;
        }

        $ch = curl_init($url);

        if($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
}