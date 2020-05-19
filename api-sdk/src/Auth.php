<?php

namespace kdl;

class Auth
{
    public $orderId;
    public $apiKey;

    function __construct($orderId, $apiKey){
        $this -> orderId = $orderId;
        $this -> apiKey = $apiKey;
    }


    /*
    *   生成签名原文字符串
    *    @param string $method 请求方法
    *    @param string $endpoint
    *    @parms array  $params 
    *    @return string  签名原文字符串
    */
    public function getStringToSign($method, $endpoint, $params){

        $query_string = "";
        
        ksort($params);
        # 此处不应该使用http_build_query函数进行url编码, 而是用"&"符将各个参数连接
        #$query_string = http_build_query($params);
        foreach($params as $key => $value){
            $query_string .= "$key=$value&";         
       }
        $query_string = rtrim($query_string, "&");

        list(, $string) = explode(".com", $endpoint);
        $string = "$method"."$string"."?"."$query_string";

        return $string;
    }
    

    /*
    *   生成签名串
    *    @param string $raw_str 签名原文字符串
    *    @param string $method  加密方法，默认sha1
    *    @return string  签名串
    */
    public function signStr($raw_str, $method="sha1"){

        $hmac_str = hash_hmac($method, $raw_str, $this->apiKey, true);
        $sign_str = base64_encode($hmac_str);

        return $sign_str;
    }

}
?>
