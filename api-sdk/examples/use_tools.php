<?php
include('../../api-sdk/src/Auth.php');
include('../../api-sdk/src/Client.php');
include('../../api-sdk/src/EndPoint.php');


use kdl\Auth;
use kdl\Client;
use kdl\EndPoint;
//  use kdl\Exception;


 $secretId = "";
 $secretKey = "";

 $auth = new Auth($secretId, $secretKey);
 $client = new Client($auth);

//  var_dump($client -> getSecretToken());
 var_dump($client -> getOrderInfo(array("sign_type" => "token")));