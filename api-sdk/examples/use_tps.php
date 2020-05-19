<?php

    include '../vendor/autoload.php';
    
    use kdl\Auth;
    use kdl\Client;
    use kdl\EndPoint;
    use kdl\Exception;



    $orderId = "";
    $apiKey = "";

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

    # 设置ip白名单，参数为一个包含"iplist"的关联数组
    # 成功则返回True, 否则false
    # 参数$args为数组，或者不传。不传表示将当前外网ip设置到白名单
    var_dump($client -> setIpWhiteList(
            $args=array(
                //  "iplist" => array("5.6.23.2", "45.23.1.5"),
                "sign_type" => "hmacsha1"
            )
    ));
    # 获取ip白名单，返回ip数组
    var_dump($client -> getIpWhiteList());

    # 显示隧道代理当前的ip
    // var_dump($client -> tpsCurrentIp());

    # 改变当前隧道ip
    // var_dump(client.changeTpsIp());

    # 获取代理鉴权信息
    # 获取指定订单访问代理IP的鉴权信息。
    # 鉴权信息包含用户名密码，用于请求私密代理/独享代理/隧道代理时进行身份验证。
    
    # 具体请看：https://www.kuaidaili.com/doc/api/getproxyauthorization/
    # 参数$args为关联数组
        # plain_text 为1 表示明文显示用户名和密码
    var_dump($client -> getProxyAuthorization(
            $args=array(
                "plaintext"=>1,
                "sign_type"=>"simple"
                )
        ));

    # 获取隧道代理IP
    # 获取订单对应的隧道代理IP。
    # 具体参数请查看：https://www.kuaidaili.com/doc/api/gettps/
    var_dump($client -> getTps(
            $args=array(
                "num" => 2,
                "sign_type" => 'hmacsha1', 
                "format" => 'json')
            ));