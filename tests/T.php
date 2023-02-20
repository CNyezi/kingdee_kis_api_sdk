<?php

use Holt\KindeeKis\Apis\Constant;
use Holt\KindeeKis\KisFactory;


require '../vendor/autoload.php';

$app = KisFactory::kis(require_once '../test_config.php');


// 获取验证码
//var_dump($app->login->getSmsCode('13316856641'));

// 验证码登录
//var_dump($app->login->loginWithCode('13316856641','776524'));

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
//var_dump($app->baseInfo->getSupplierList());

// 批量查询核算项目信息详情
//var_dump($app->baseInfo->getAccountingItemList());

//批量查询科目基础资料详情
var_dump(json_encode($app->baseInfo->getAccountList()));

// 部门列表
//var_dump($app->baseInfo->getDepartmentList());
// 职员列表
//var_dump(json_encode($app->baseInfo->getEmployeeList()));

// 获取应付账单列表
//var_dump($app->pay->getOtherApBillList(1, 20));

// 创建应付账单
//var_dump($app->pay->createOtherAp([
//    "FAccountID" => 1003,
//    // 为供应商id
//    "FCustomer" => 245,
//    "FDate" => date('Y-m-d'),
//    "FFincDate" => date('Y-m-d'),
//    // 币种
//    "FCurrencyID" => 1,
//    // 汇率
//    "FExchangeRate" => 1,
//    "FYear" => date('Y'),
//    "FPeriod" => "2",
//    // 不知道是啥
//    "FBillType" => 992,
//    // 核算项目类别
//    "FItemClassID" => Constant::CLASS_SUPPLIER, // 可以固定
//    // 不知道是啥
//    "FItemClassType" => 2,
//    "FInterestRate" => 0,
//    "FDepartment" => 2,
//    "FEmployee" => 0,
//    // 摘要
//    "FExplanation" => "这里是随便写一些内容的地方"
//], [
//    [
//        "FDate" => '2023-05-10',
//        "FAmountFor" => 500.0000
//    ]
//], [
//    ["FAmountFor" => 500.0000]
//]));