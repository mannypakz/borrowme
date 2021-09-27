<?php
namespace App\Libraries;
Class Shopify {

    private $creds       = [];
    private $api_counter = 1;
    private $api_timer   = [];

    public function __construct ($creds) {
        if(!empty($creds['api_token'])) {
            $this->api_url  = "https://".$creds['shop_name'].".myshopify.com/admin/api/2019-10";
            $this->token    = $creds['api_token'];
        } else {
            $this->api_url  = "https://".$creds['api_key'].":".$creds['api_password']."@".$creds['shop_name'].".myshopify.com/admin/api/2019-10";
        } 
    }

    public function s_get($endpoint,$params=[]) {
        $g_params=array();
        foreach($params as $key=>$param) {
            $g_params[] = $key."=".$param;
        }
        $g_params    = implode("&",$g_params);
        $res    = $this->call("get","$this->api_url/$endpoint?$g_params");
        return $res;
    }

    public function s_post($endpoint,$data=[]) {
        $data = json_encode($data);
        $res  = $this->call('post',"$this->api_url/$endpoint",$data);
        return $res;
    }

    public function s_put($endpoint,$data=[]) {
        $data = json_encode($data);
        $res  = $this->call('put',"$this->api_url/$endpoint",$data);
        return $res;
    }

    public function s_delete($endpoint) {
        $res=$this->call("delete","$this->api_url/$endpoint");
        return $res;
    }

    private function call($method, $url, $params=array()) {
        $this->api_timer[$this->api_counter]=microtime(true);
        if($this->api_counter == 2)  {
            $duration = $this->api_timer[$this->api_counter]-$this->api_timer[$this->api_counter-1];
            if($duration < 1) {
                $tdiff = 1-$duration;
                $m_sleep = ($tdiff*1000000);
                usleep($m_sleep);
            }
            $this->api_counter = 0;
        }
        $this->api_counter++;

        $headers = []; $matches = [];
        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);

        $request_headers[] = "";
        if(!empty($this->token)) {
            $request_headers[] = "X-Shopify-Access-Token: " . $this->token;
        }
        $request_headers[] = 'Content-Type: application/json; charset=utf-8';
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($shopcurl, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) >= 2)
                $headers[strtolower(trim($header[0]))] = trim($header[1]);
            return $len;
        });
        if($method=="post"){
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($shopcurl, CURLOPT_POST, true);
            curl_setopt($shopcurl, CURLOPT_POSTFIELDS, $params);
        }elseif($method=="delete") {
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }elseif($method=="put") {
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($shopcurl, CURLOPT_POSTFIELDS, $params);
        }
        $response['result']   = json_decode(curl_exec($shopcurl));
        $response['httpcode'] = curl_getinfo($shopcurl, CURLINFO_HTTP_CODE);
        if(isset($headers['link'])) {
            preg_match('/<(.*)>; rel="next"/', $headers['link'], $matches);
            if(isset($matches[1])) {
                 parse_str(parse_url($matches[1])['query'],$response['link']);
            }
        }
        curl_close($shopcurl);
        if( (isset($headers['x-shopify-shop-api-call-limit']) && $headers['x-shopify-shop-api-call-limit'] == "35/40") || $response['httpcode'] == '429' ) {
            sleep(10);
        }
        return $response;
    }
}