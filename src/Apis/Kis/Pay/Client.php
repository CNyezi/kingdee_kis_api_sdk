<?php

namespace Holt\KindeeKis\Apis\Kis\Pay;

use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Events\HttpResponseCreated;

class Client extends BaseClient
{

    protected $needGateway = true;

    /**
     * 获取其他应付账单列表
     * @param $page
     * @param $pageSize
     * @param $orderField
     * @param $sort
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getOtherApBillList($page, $pageSize, $orderField = 'FDate', $sort = 'desc', $accountDb = '')
    {
        $params = [
            "CurrentPage" => $page,
            "ItemsOfPage" => $pageSize,
            "OrderBy" => [
                "Property" => $orderField,
                "Type" => $sort
            ]
        ];

        if ($accountDb != '') {
            $params[] = [
                'AccountDb' => $accountDb,
            ];
        }

        return $this->httpPostJson('/koas/APP007020/api/OtherApBill/List', $params);
    }

    /**
     * 新增其他应付账单
     * doc link
     * https://open.jdy.com/#/files/api/detail?index=2&categrayId=dded94c553614747b2c9b8b49c396aa6&id=42a99333755611ed86f705c49066d110
     */
    public function createOtherAp($head, $entryList, $entry2List)
    {
        $params = [
            "Object" => [
                "Head" => $head,
                "Entry" => $entryList,
                "Entry2" => $entry2List
            ]
        ];
        return $this->httpPostJson('/koas/APP007020/api/OtherApBill/Create', $params);
    }
    // 参考请求体
    //[
    //            "Object" => [
    //                "Head" => [
    //                    "FAccountID" => 1092,
    //                    "FCustomer" => 272,
    //                    "FDate" => "2021-12-13T00=>00=>00",
    //                    "FFincDate" => "2021-12-13T00=>00=>00",
    //                    "FCurrencyID" => 1,
    //                    "FExchangeRate" => 1,
    //                    "FYear" => "2021",
    //                    "FPeriod" => "1",
    //                    "FBillType" => 992,
    //                    "FItemClassID" => 1,
    //                    "FItemClassType" => 2,
    //                    "FInterestRate" => 0,
    //                    "FExplanation" => "test"
    //                ],
    //                "Entry" => [
    //                    [
    //                        "FDate" => "2021-03-18",
    //                        "FAmountFor" => 500.0000
    //                    ]
    //                ],
    //                "Entry2" => [
    //                    [
    //                        "FAmountFor" => 500.0000
    //                    ]
    //                ]
    //            ]
    //        ]


}