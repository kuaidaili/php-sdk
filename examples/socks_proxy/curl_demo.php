<?php
// 要访问的目标页面
$targetUrl = "https://dev.kdlapi.com/testproxy";

// 代理ip
$proxyIp = "59.38.241.25";
$proxyPort = "23916";
$username = "username";
$password = "password";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $targetUrl);

curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// 设置代理
curl_setopt($ch, CURLOPT_PROXYTYPE, 5); //sock5
curl_setopt($ch, CURLOPT_PROXY, "{$proxyIp}:{$proxyPort}");

//设置代理用户名密码
curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$username}:{$password}");

// 设置UA
curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0);");

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

curl_setopt($ch, CURLOPT_TIMEOUT, 10);

curl_setopt($ch, CURLOPT_HEADER, true);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

curl_close($ch);

var_dump($result);