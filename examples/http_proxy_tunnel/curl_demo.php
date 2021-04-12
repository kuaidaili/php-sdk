<?php
//要访问的目标页面
$page_url = "http://dev.kdlapi.com/testproxy";


$ch = curl_init();
$tunnelhost = "tunnelhost";
$tunnelport = "tunnelport";
$proxy = $tunnelhost.":".$tunnelport;

//隧道用户名密码
$username   = "username";
$password   = "password";

//$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $page_url);

//发送post请求
$requestData["post"] = "send post request";
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

//设置代理
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
//设置代理用户名密码
curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$username}:{$password}");

//自定义header
$headers = array();
$headers["user-agent"] = 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0);';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//自定义cookie
curl_setopt($ch, CURLOPT_COOKIE,'');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //使用gzip压缩传输数据让访问更快

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "$result"; // 使用请求页面方式执行时，打印变量需要加引号
echo "\n\nfetch ".$info['url']."\ntimeuse: ".$info['total_time']."s\n\n";
?>