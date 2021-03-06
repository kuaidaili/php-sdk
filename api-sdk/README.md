# 简介
快代理php  api-sdk

## 通过conposer安装(推荐)
您可以通过`npm`将SDK安装到您的项目中：
```
composer require kuaidaili/php_sdk
```
如果您的项目环境尚未安装`composer`，可参考：

* [官方文档](https://docs.phpcomposer.com/00-intro.html)

## 示例
以私密代理订单使用为例
``` javascript
<?php

    # 包含自动加载文件
    include './vendor/autoload.php';
    
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
    # 参数$args可以传或者不传。不传表示将当前外网ip设置到白名单
    var_dump($client -> setIpWhiteList(
            $args=array(
                //  "iplist" => array("5.6.23.2", "45.23.1.5"),
                "sign_type" => "hmacsha1"
            )
    ));
    # 获取ip白名单，返回ip数组
    var_dump($client -> getIpWhiteList());

    
    # 获取私密代理
    # 返回值为一个包含ip的数组
    $ips = $client -> getDps($args=array(
            "num" => 2, // 提取数量
            "sign_type" => 'simple', 
            "format" => 'json' // 如果format不指定为json, 将会以为原始内容返回。而不是以数组形式返回
            )
    );
    var_dump($ips);
    # 检测私密代理有效性： 返回 ip: 1/0 组成的关联数组。1表示有效，0表示无效
    $valids = $client -> checkDpsValid($args=array(
                "proxy" => $ips
                )
            );
    var_dump($valids);
    $second = $client -> getDpsValidTime($args=array(
                "proxy" => $ips
                )
            );
    var_dump($second);

    # 获取计数版ip余额（仅私密代理计数版）
    $balance = $client -> getIpBalance($args=array(
            "sign_type" => 'hmacsha1'
            )
    );
    var_dump($balance);

 
    // # 获取代理鉴权信息
    // # 获取指定订单访问代理IP的鉴权信息。
    // # 鉴权信息包含用户名密码，用于请求私密代理/独享代理/隧道代理时进行身份验证。
    
    // # 具体请看：https://www.kuaidaili.com/doc/api/getproxyauthorization/
    // # 参数$args为关联数组
    //     # plain_text 为1 表示明文显示用户名和密码
    var_dump($client -> getProxyAuthorization(
            $args=array(
                "plaintext"=>1,
                "sign_type"=>"simple"
                )
        ));
```
      您可以在examples目录下找到更详细的示例

## 参考资料

* [查看API列表](https://www.kuaidaili.com/doc/api/)
* [了解API鉴权](https://www.kuaidaili.com/doc/api/auth/)
