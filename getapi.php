<?php

/*
 * 本例中使用PHP调用cURL
 * PHP cURL 官方文档地址：  http://php.net/manual/zh/book.curl.php
 *
 */

//初始化
$ch = curl_init();

//订单号
$order_id = '965102959536478';

//构造请求链接
$api_url = "http://dev.kuaidaili.com/api/getproxy/?orderid=$order_id&num=100&protocol=1&method=2&an_ha=1&sep=1";

//设置URL
curl_setopt($ch,CURLOPT_URL,$api_url);

//TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//执行
//获取返回结果
$data = curl_exec($ch);

//获取返回HTTP Code
$HTTP_Code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 

var_dump($data);
var_dump($HTTP_Code);


?>