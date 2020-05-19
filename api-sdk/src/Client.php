<?php

namespace kdl;
use kdl\Exception\KdlException;
use kdl\Exception\KdlStatusError;
use kdl\Exception\KdlNameError;
use kdl\Exception\KdlTypeError;
use kdl\EndPoint;
use kdl\OpsOrderLevel;


    class Client
    {

        function __construct($auth){
            @set_exception_handler(array($this, 'exception_handler'));

            $this -> auth = $auth;
        }

        /*
        *   获取订单到期时间, 强制签名验证
        *    @param args
        *    (
        *       "sign_type": 认证方式, simple或hmacsha1
        *    )
        *    @return 订单过期时间字符串
        */
        public function getExpireTime($args=array()){

            $endpoint = EndPoint::GetOrderExpireTime;
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET", 
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );
            
            if(is_array($res)){
                return $res["data"]["expire_time"];
            }
            return $res;
        }

        /*
        *   获取指定订单访问代理IP的鉴权信息。
        *   鉴权信息包含用户名密码，用于请求私密代理/独享代理/隧道代理时进行身份验证。
        *   @params args
        *           (
        *               "plain_text": 是否明文返回用户名密码, 1表示是, 0表示否
        *               "sign_type": 签名验证方式。目前支持simple和hmacsha1 
        *           )
        *   @return 返回信息的数组
        */
        public function getProxyAuthorization($args=array()){

            # 设定默认参数值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";
            $args["plaintext"] = isset($args["plaintext"]) ? $args["plaintext"] : 0;

            $endpoint = EndPoint::GetProxyAuthorization;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET", 
                    $endponit = $endpoint, 
                    $query = http_build_query($params)
            );
            if(is_array($res)){
                return $res["data"];
            }
            return $res;
        }

        /*
        *   仅支持支持换IP周期>=1分钟的隧道代理订单
        *   获取隧道当前的IP，默认“simple”鉴权
        *   @params args
        *           (
        *               "sign_type": 签名验证方式。目前支持simple和hmacsha1 
        *           )
        *   @return:返回ip地址。
        */
        public function tpsCurrentIp($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            $endpoint = EndPoint::TpsCurrentIp;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET",
                    $endpoint = $endpoint,
                    $query = http_build_query($params)
            );
            return $res['data']['current_ip'];
        }


        /*
        *   仅支持支持换IP周期>=1分钟的隧道代理订单
        *   @params args
        *           (
        *               "sign_type": 签名验证方式。目前支持simple和hmacsha1 
        *           )
        *   @return: 返回新的IP地址
        */
        public function changeTpsIp($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            $endpoint = EndPoint::ChangeTpsIp;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this->_get_base_res(
                    $method = "GET",
                    $endpoint=$endpoint,
                    $query = http_build_query($params)
            );
            return $res['data']['new_ip'];
        }
        

        /*
        *    获取隧道代理IP, 默认"simple"鉴权 https://www.kuaidaili.com/doc/api/gettps/
        *    @params args
        *    (
        *            "sign_type": 签名验证方式。目前支持simple和hmacsha1
        *            "num" : 提取数量
        *            "kwargs": 其他关键字参数，具体有那些参数请查看帮助中心api说明
        *    )
        *    @return 若为json格式, 则返回data中proxy_list部分, 即proxy列表, 否则原样返回
        */
        public function getTps($args=array()){

                # 设置默认值
                $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";
                if( !isset($args["num"]) ) throw new KdlNameError("miss param: num");
                if( !ctype_digit(strval($args["num"])) ) throw new KdlTypeError("num should be a integer or a integer string");
                $endpoint = EndPoint::GetTps;
                $params = $this -> _get_params($endpoint, $args);
                $res = $this -> _get_base_res(
                        $method = "GET", 
                        $endpoint = $endpoint, 
                        $query = http_build_query($params)
                );
                if( is_array($res) ) return $res['data']['proxy_list'];
                return $res;
        }


        /*
        *    获取订单的ip白名单, 强制签名验证
        *    @param args
        *    (
        *          "sign_type": 认证方式, simple或hmacsha1
        *    )
        *    @return ip白名单列表
        */
        public function getIpWhiteList($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            $endpoint = EndPoint::GetIpWhitelist;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET", 
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );
            // var_dump($res);
            if(is_array($res)){
                return $res["data"]["ipwhitelist"];
            }
            return $res;
        }


        /*
        *    获取私密代理, 默认"simple"鉴权
        *    @param args
        *    (
        *        "sign_type": 认证方式, simple或hmacsha1
        *        "num": 提取数量, int类型
        *        "kwargs": 其他关键字参数，具体有那些参数请查看帮助中心api说明
        *    )
        *    @return 以数组形式返回data中proxy_list部分, 即proxy列表
        */
        public function getDps($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["num"]) ) throw new KdlNameError("miss param: num");
            if( !ctype_digit(strval($args["num"])) ) throw new KdlTypeError("num should be a integer or a integer string");
            $endpoint = EndPoint::GetDpsProxy;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET",
                    $endpoint = $endpoint,
                    $query = http_build_query($params)
            );
            if(is_array($res)) return $res['data']['proxy_list'];
            return $res;
        }

        /*
        *    检测私密代理有效性, 强制签名验证
        *    @param args
        *    (
        *        "proxy": 私密代理列表的一维数组, 如 array('113.120.61.166:22989','122.4.44.132:21808')
        *        "sign_type": 认证方式, simple或hmacsha1
        *    )
        *    @return 返回data部分, 格式为由'proxy: 1/0'组成的数组
        */
        public function checkDpsValid($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["proxy"]) ) throw new KdlNameError("miss param: proxy");
            if( !is_array($args["proxy"]) ) throw new KdlTypeError("args['proxy'] should be a array");
            $args["proxy"] = implode(",", $args["proxy"]);
            $endpoint = EndPoint::CheckDpsValid;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET",
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );
            return $res["data"];
        }

        public function getDpsValidTime($args=array()){
        /*  
            获取私密代理ip有效时间
            :param args
            (
                "proxy": 私密代理列表的一维数组, 如 array('113.120.61.166:22989','122.4.44.132:21808')
                "sign_type": 认证方式, simple或hmacsha1
            )
            :return: 返回data部分, 格式为由'proxy: seconds(剩余秒数)'组成的关联数组
        */
            
            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["proxy"]) ) throw new KdlNameError("miss param: proxy");
            if( !is_array($args["proxy"]) ) throw new KdlTypeError("args['proxy'] should be a array");
            $args["proxy"] = implode(",", $args["proxy"]);
            $endpoint = EndPoint::GetDpsValidTime;
            $params = $this -> _get_params($endpoint,$args);
            $res = $this -> _get_base_res(
                    $method = "GET",
                    $endponit = $endpoint,
                    $query = http_build_query($params)
            );
            return $res["data"];               
            
        }


        /*
        *    获取计数版订单ip余额, 强制签名验证,
        *    此接口只对按量付费订单和包年包月的集中提取型订单有效
        *    @params args
        *    (
        *        "sign_type": 认证方式, simple或hmacsha1
        *    )
        *    @return 返回data中的balance字段, int类型
        */
        public function getIpBalance($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            $endpoint = EndPoint::GetIpBalance;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET", 
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );

            return $res["data"];
        }


        /*
        *    获取独享代理, 默认"simple"鉴权
        *    @params args
        *    (
        *       "sign_type": 认证方式, simple或hmacsha1
        *        "num": 提取数量
        *         其他关键字参数，具体有那些参数请查看帮助中心api说明
        *    )
        *    @return 若为json格式, 则返回data中proxy_list部分, 即proxy数组, 否则原样返回
        */
        public function getKps($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["num"]) ) throw new KdlNameError("miss param: num");
            if( !ctype_digit(strval($args["num"])) ) throw new KdlTypeError("num should be a integer or a integer string");
            $endpoint = EndPoint::GetKpsProxy;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this ->_get_base_res(
                $method = "GET", 
                $endpoint = $endpoint, 
                $query = http_build_query($params)
            );
            if (is_array($res)) return $res["data"]["proxy_list"];
            return $res;
        }


        /*
        *    获取开放代理, 默认不需要鉴权
        *    @params args
        *    (
        *        "sign_type": 认证方式, simple或hmacsha1
        *        "order_level": 开放代理订单类型
        *        "num": 提取数量
        *        其他关键字参数，具体有那些参数请查看帮助中心api说明
        *    )
        *    @return 若为json格式, 则返回data中proxy_list部分, 即proxy数组, 否则原样返回
        */
        public function getProxy($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["num"]) ) throw new KdlNameError("miss param: num");
            if( !ctype_digit(strval($args["num"])) ) throw new KdlTypeError("num should be a integer or a integer string");
            $endpoint = EndPoint::GetOpsProxyNormalOrVip;
            if($endpoint == OpsOrderLevel::SVIP)$endpoint = EndPoint::GetOpsProxySvip;
            if($endpoint == OpsOrderLevel::PRO) $endpoint = OpsOrderLevel::PRO;
            unset($args["order_level"]);        // $args["order_level"] can't pass function _get_params.

            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method = "GET", 
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );
            if(is_array($res)) return $res['data']['proxy_list'];
            return $res;
        }


        /*
        *    检测开放代理有效性, 强制签名验证
        *    @params args
        *    (
        *        "sign_type": 认证方式, simple或hmacsha1
        *        "proxy": 私密代理列表的一维数组, 如 array('113.120.61.166:22989','122.4.44.132:21808')
        *    )
        *    @return 返回data部分, 格式为由'proxy: True/False'组成的列表
        */
        public function checkOpsValid($args=array()){

            # 设置默认值
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";

            if( !isset($args["proxy"]) ) throw new KdlNameError("miss param: proxy");
            if( !is_array($args["proxy"]) ) throw new KdlTypeError("args['proxy'] should be a array");
            $args["proxy"] = implode(",", $args["proxy"]);
            $endpoint = EndPoint::CheckOpsValid;
            $params = $this -> _get_params($endpoint, $args);
            $res = $this ->_get_base_res(
                    $method = "GET",
                    $endpoint = $endpoint, 
                    $query = http_build_query($params)
            );
            if(is_array($res)) return $res['data'];
            return $res;
        }


        /*设置订单的ip白名单, 强制签名验证
        *    @param args
        *           (
        *               "iplist": 一维数组, 如('23.5.3.2', '35.2.1.3')
        *               "sign_type": 认证方式, simple或hmacsha1
        *           )
        *    @return 成功则返回True, 否则抛出异常
        */
        public function setIpWhiteList($args=array()){

            $endpoint = EndPoint::SetIpWhitelist;
            if( isset($args) && !(is_array($args)) ){
                echo "args should be a array \n";
                return false;
            }
            #if( !isset($args["iplist"]) ) throw new KdlNameError($message="miss param: iplist", $code=-1);
            if(isset($args["iplist"])) $args["iplist"] = implode(",", $args["iplist"]);
            $args["sign_type"] = isset($args["sign_type"]) ? $args["sign_type"] : "simple";
            # iplist要求为字符串，多个以逗号分隔
            
            $params = $this -> _get_params($endpoint, $args);
            $res = $this -> _get_base_res(
                    $method  = "POST",
                    $endpoint = $endpoint,
                    $query = http_build_query($params)
            );
            return true;
        }


        /*
        *    处理基础请求,
        *    若响应为json格式则返回请求结果
        *    否则直接返回原格式
        *    @param string $method: 请求方法, GET或POST 
        *    @param string $endponit: api接口
        *    @param string $query: query string     
        */
        private function _get_base_res($method, $endpoint, $query){

            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_ENCODING       => "",
                CURLOPT_AUTOREFERER    => true, 
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 10,
            #    CURLOPT_POST            => 0,
                CURLOPT_VERBOSE        => 0 
            );
            $headers = array(
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3",
                #"Host: dev.kdlapi.com",
                "Accept-Encoding: gzip, deflate, br",
                "Accept-Language: zh-CN,zh;q=0.9",
                "Connection: keep-alive",
            );

            if ($method == "GET"){
                $url = "https://$endpoint?$query";
                // echo $url, "\n";
                #$url = "https://httpbin.org/get?$query";
                $ch = curl_init($url);
                curl_setopt($ch,  CURLOPT_HTTPHEADER, $headers);
                curl_setopt_array($ch, $options);
                $r = curl_exec($ch);

            }
            elseif ($method == "POST"){
                $url = "https://$endpoint";
                $ch = curl_init($url);
                curl_setopt($ch,  CURLOPT_HTTPHEADER, $headers);
                $options[CURLOPT_POST] = 1;
                $options[CURLOPT_POSTFIELDS] = $query;
                curl_setopt_array($ch, $options);
                $r = curl_exec($ch);
            }
            #echo "$r", "\n";

            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            # 非200状态码，抛出异常
            if($status_code != 200) throw new KdlStatusError($message=$r, $code=$status_code);

            # json_decode函数失败将返回null
            $res = json_decode($r, true);
            # 如果不是Json数据，直接返回
            if($res === NULL){
                return $r;   // 还需要测试
            }

            # 获取api接口返回的code和message, 如果code为非0, 则获取数据失败
            $code = $res['code'];
            $msg = $res['msg'];
            if($code != 0) {
                #    echo $msg;      // 抛出异常 , 还需测试    
                #    echo $code;
                throw new KdlException($message=$msg, $code=$code);
            }

            curl_close($ch);
            return $res;
        }


        /*
        *    构造请求参数
        *    @param string $endpoint: api接口
        *    @param array 
        *        $args: (
        *                    'sign_type': 认证方式
        *                    ...(一些需要编入url中的参数)
        *               )
        *    @return string         
        */
        private function _get_params($endpoint, $args=array()){

            # 如果没有给orderid和apikey或者为空,则 抛出异常
            if( !($this->auth->orderId && $this->auth->apiKey) ){
               throw new KdlNameError("wrong orderId or apiKey"); 
            }

            $params["orderid"] = $this -> auth -> orderId;
            
            # 参数args是必须的
            if( isset($args) && is_array($args) ){
                foreach( $args as $key => $value ){
                    $params["$key"] = $value;
                }
            }
            else{
                echo "_get_params miss keywords \n";
                exit(1);
            }


            switch($params["sign_type"]){
                case "":
                    break;
                case "simple":
                    $params['signature'] = $this -> auth -> apiKey;
                    break;
                case "hmacsha1":
                    $params['timestamp'] = (int)time();
                    if($endpoint == EndPoint::SetIpWhitelist){
                        $raw_str = $this ->auth -> getStringToSign("POST", $endpoint, $params);
                        #echo "$raw_str\n";
                    }
                    else{
                        $raw_str = $this ->auth -> getStringToSign("GET", $endpoint, $params);
                    }
                    $params["signature"] = $this -> auth -> signStr($raw_str, $method="sha1");
                    break;
                default:
                   throw new KdlNameError("unknown sign_type".$params["sign_type"]); 
            }
            return $params;

        }

        // 自定义处理异常使用的方法
        public function exception_handler($exception) {
            echo $exception, "\n"; 
        }
 
?>
