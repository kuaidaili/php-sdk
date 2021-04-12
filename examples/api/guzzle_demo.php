<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

//api链接
$api_url = "http://dev.kdlapi.com/api/getproxy/?orderid=96518362xxxxxx&num=100&protocol=1&method=2&an_ha=1&sep=1";

$client = new Client();
$res = $client->request('GET', $api_url, [
    'headers' => [
        'Accept-Encoding' => 'gzip'  // 使用gzip压缩让数据传输更快
    ]
]);


echo $res->getStatusCode(); //获取Reponse的返回码
echo "\n\n";
echo $res->getBody(); //获取API返回内容
?>