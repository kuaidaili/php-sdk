<?php

namespace kdl;

class EndPoint
{
    //各个api的主机+路径
    const GetOrderExpireTime = "dev.kdlapi.com/api/getorderexpiretime";
    const GetIpWhitelist = "dev.kdlapi.com/api/getipwhitelist"; # 获取IP白名单
    const SetIpWhitelist = "dev.kdlapi.com/api/setipwhitelist"; # 设置IP白名单
    const GetKpsProxy = "kps.kdlapi.com/api/getkps";
    const GetDpsProxy = "dps.kdlapi.com/api/getdps";
    const GetOpsProxyNormalOrVip = "dev.kdlapi.com/api/getproxy";
    const GetOpsProxySvip = "svip.kdlapi.com/api/getproxy";
    const GetOpsProxyEnt = "ent.kdlapi.com/api/getproxy";
    const CheckDpsValid = "dps.kdlapi.com/api/checkdpsvalid";
    const CheckOpsValid = "dev.kdlapi.com/api/checkopsvalid";
    const GetIpBalance = "dps.kdlapi.com/api/getipbalance";
    const GetDpsValidTime = "dps.kdlapi.com/api/getdpsvalidtime";
    const TpsCurrentIp = "tps.kdlapi.com/api/tpscurrentip"; # 获取当前隧道代理IP
    const ChangeTpsIp = "tps.kdlapi.com/api/changetpsip"; # 更改当前隧道代理IP
    const GetTps = "tps.kdlapi.com/api/gettps";  # 获取隧道代理IP
    const GetProxyAuthorization = "dev.kdlapi.com/api/getproxyauthorization"; # 获取代理鉴权信息    
    const GetUA = "dev.kdlapi.com/api/getua";    # 获取User Agent
    const GetAreaCode = "dev.kdlapi.com/api/getareacode";    # 获取指定地区编码
    const GetAccountBalance = "dev.kdlapi.com/api/getaccountbalance";    # 获取账户余额
    const CreateOrder = "dev.kdlapi.com/api/createorder";   # 创建订单
    const GetOrderInfo = "dev.kdlapi.com/api/getorderinfo";  # 获取订单信息
    const SetAutoRenew = "dev.kdlapi.com/api/setautorenew";  # 开启/关闭自动续费
    const CloseOrder = "dev.kdlapi.com/api/closeorder";  # 关闭订单
    const QueryKpsCity = "dev.kdlapi.com/api/querykpscity";  # 查询独享代理城市信息

    const GetSecretToken = "auth.kdlapi.com/api/get_secret_token";  # 获取secret
}

?>
