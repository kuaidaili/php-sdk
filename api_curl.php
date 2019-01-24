<?php
    //api链接
    $api_url = "http://dev.kdlapi.com/api/getproxy/?orderid=965102959536478&num=100&protocol=1&method=2&an_ha=1&sep=1";

    $opts = array('http' =>
        array(
            'method'  => 'GET',
            'header'  => '',
        )
    );

    $context = stream_context_create($opts);

    $result = file_get_contents($api_url, false, $context);

    echo $result
?>