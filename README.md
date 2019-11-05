# 快代理SDK - php

## 调用API
### api_guzzle.php
使用`Guzzle`库调用api示例
```
Guzzle是一个简单强大的http客户端库, 需要安装才能使用:
1. 安装composer: curl -sS https://getcomposer.org/installer | php
2. 安装Guzzle: php composer.phar require guzzlehttp/guzzle:~6.0
```

### api_stream.php
使用`stream`流调用api示例

### api_curl.php
使用`curl`调用api示例
```
curl不是php原生库, 需要安装才能使用
* Ubuntu/Debian系统: apt-get install php5-curl
* CentOS系统: yum install php-curl
```

## Http代理
### http_curl.php
使用`curl`请求Http代理服务器, 请求http和https网页均适用
```
curl不是php原生库, 需要安装才能使用
* Ubuntu/Debian系统: apt-get install php5-curl
* CentOS系统: yum install php-curl
```

## 隧道代理
### tps_curl.php
使用`curl`请求隧道代理服务器, 请求http和https网页均适用
```
curl不是php原生库, 需要安装才能使用
* Ubuntu/Debian系统: apt-get install php5-curl
* CentOS系统: yum install php-curl
```


## 技术支持
如果您发现代码有任何问题, 请提交`Issue`。

欢迎提交`Pull request`以使代码样例更加完善。

获取更多关于调用API和代理服务器使用的资料，请参考[开发者指南](https://help.kuaidaili.com/dev/api/)。

* 技术支持微信：<a href="https://img.kuaidaili.com/img/service_wx.jpg">kuaidaili</a>
* 技术支持QQ：<a href="http://q.url.cn/CDksXo?_type=wpa&qidian=true">800849628</a>
