<?php

/*
 * 本例中使用PHP调用cURL设置代理
 * PHP cURL 官方文档地址：  http://php.net/manual/zh/book.cURL.php
 *
 * 注意：以下例子中为了方便演示使用了curl_setopt 函数是设置cURL传输选项，如果选项过多建议使用curl_setopt_array 通过数组的方式传递选项。
 *
 */

$ch = cURL_init();

//访问http://2017.ip138.com/ic.asp
curl_setopt($ch, CURLOPT_URL, 'http://2017.ip138.com/ic.asp');

//设置代理服务器的 IP以及Port
curl_setopt($ch, CURLOPT_PROXY,'59.38.241.25');
curl_setopt($ch, CURLOPT_PROXYPORT, 23916);

//设置代理服务器类型  默认是HTTP类型  可省略
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);

//如果是访问HTTPS类型的网站需要加上（不验证证书）
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

//如果您购买的是开放代理或者您已经设置了IP白名单，就不需要下面的账号密码验证操作 直接注释即可
curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_PROXYUSERNAME, 'myusername');
curl_setopt($ch, CURLOPT_PROXYPASSWORD, 'mypassword');

//不输出返回的数据
curl_setopt($ch, CURLOPT_HEADER, 0);
//	TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//http://2017.ip138.com/ic.asp 默认返回的是gb2312的编码  为了一致性将其转换为utf-8
$data = iconv('gb2312','utf-8',CURL_exec($ch));

cURL_close($ch);

var_dump($data);

?>