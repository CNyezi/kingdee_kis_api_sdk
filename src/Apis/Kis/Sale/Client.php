<?php

namespace Holt\KindeeKis\Apis\Kis\Sale;

use Holt\KindeeKis\Kernel\BaseClient;

class Client extends BaseClient
{
    protected $needGateway = true;

    /**
     * 获取销售单列表
     * @param $page
     * @param $pageSize
     * @param $orderByProperty
     * @param $orderByType
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function saleOrderList($page = 1, $pageSize = 20, $orderByProperty = '', $orderByType = '', $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != '') {
            $params[]= [
                'AccountDb' => $accountDb,
            ];
        }
        return $this->httpPostJson('/koas/app007099/api/salesorder/list', $params);
    }


    /**
     * 获取销售单详情
     * @param $id
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function saleOrderDetail($id, $accountDb = '')
    {
        $params = [
            'Id' => $id
        ];

        if ($accountDb != '') {
            $params[] = [
                'AccountDb' => $accountDb,
            ];
        }

        return $this->httpPostJson('/koas/app007099/api/salesorder/getdetail', $params);
    }

    /**
     * 获取发货单列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function deliveryNoticeList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != '') {
            $params[] = [
                'AccountDb' => $accountDb,
            ];
        }

        return $this->httpPostJson('/koas/app007099/api/deliverynotice/list', $params);
    }

    /**
     * 获取发货单详情
     * @param $id
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function deliverNoticeDetail($id, $accountDb = '')
    {
        $params = [
            'Id' => $id
        ];

        if ($accountDb != '') {
            $params[] = [
                'AccountDb' => $accountDb,
            ];
        }

        return $this->httpPostJson('/koas/app007099/api/deliverynotice/getdetail', $params);
    }


}