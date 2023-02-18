<?php

use Holt\KindeeKis\Apis\Constant;
use Holt\KindeeKis\KisFactory;


require '../vendor/autoload.php';

$app = KisFactory::kis([
    'app_id' => '240640',
    'app_secret' => 'a795c44fc000656d38e81eb5d7420486',
    'company_id' => 1
]);

// 获取验证码
//var_dump($app->login->getSmsCode('13316856641'));

// 验证码登录
//var_dump($app->login->loginWithCode('13316856641','396191'));

// 获取有权限的账套列表
//var_dump($app->account->getAccountsList());

// 获取对应账套列表的应用数据
//var_dump($app->account->getAppList('UE122159562023021513464342', '1676439822b3fe529af084e3bb28a2bd'));

// 根据应用数据，获取应用网关地址，并配置网关信息
//var_dump($app->account->getAndSetUpAccountGateway('1676439822b3fe529af084e3bb28a2bd',
//    'UE122159562023021513464342', '40284830960592ce361ca601639open8'));

// 验证网关信息缓存
//var_dump($app->gateway->getGatewayInfo());

// 获取供应商数据
//var_dump($app->baseInfo->getBaseInfoList(Constant::BASE_ID_PROJECT, Constant::CLASS_SUPPLIER));


// 获取应付账单列表
var_dump($app->pay->getOtherApBillList(1, 20));
