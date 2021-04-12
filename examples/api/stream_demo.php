<?php

// gzip解压缩函数
if (!function_exists('gzdecode')) {
    function gzdecode($data) {
        // strip header and footer and inflate
        return gzinflate(substr($data, 10, -8));
    }
}

//api链接
$api_url = "http://dev.kdlapi.com/api/getproxy/?orderid=96518362xxxxxx&num=100&protocol=1&method=2&an_ha=1&sep=1";

$opts = array('http' =>
    array(
        'method'  => 'GET',
        'header'  => 'Accept-Encoding: gzip',  // 使用gzip压缩让数据传输更快
    )
);

$context = stream_context_create($opts);

$result = file_get_contents($api_url, false, $context);

echo gzdecode($result);  // 输出返回内容
?>