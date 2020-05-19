<?php

    include '../vendor/autoload.php';
    
    use kdl\Auth;
    use kdl\Client;
    use kdl\EndPoint;
    use kdl\Exception;



    $orderId = "947449222924633";
    $apiKey = "atvb6a4981d03pvpqalolea9e0k2pmi6";

    $auth = new Auth($orderId, $apiKey);
    $client = new Client($auth);

    # 注意：所有函数参数$args都是关联数组形式
    # 如
    # $args = array(
        # "sign_type" => "hmacsha1" // 认证方式, simple或hmacsha1 默认为simple
        # ... 
    #)

    # 获取订单到期时间, 返回时间字符串
    var_dump($client -> getExpireTime($args=array("sign_type" => "hmacsha1")));


    # 提取开放代理ip，(不需要传入signature）
    # 具体有哪些参数请参考帮助中心: "https://help.kuaidaili.com/api/getdps/"
    # 返回ip数组

    $ips = $client -> getProxy($args=array(
        "num" => "4",
        "order_level" => "sivp",
        "format" => "json"
    ));

    var_dump($ips);
