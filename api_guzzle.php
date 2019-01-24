<?php
    require 'vendor/autoload.php';
    use GuzzleHttp\Client;

    //api链接
    $api_url = "http://dev.kdlapi.com/api/getproxy/?orderid=965102959536478&num=100&protocol=1&method=2&an_ha=1&sep=1";

    $client = new Client();
    $res = $client->request('GET', $api_url);

    echo $res->getStatusCode(); //获取Reponse的返回码
    echo "\n\n";
    echo $res->getBody(); //获取API返回内容
?>