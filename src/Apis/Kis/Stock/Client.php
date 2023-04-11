<?php

namespace Holt\KindeeKis\Apis\Kis\Stock;

use Holt\KindeeKis\Kernel\BaseClient;

class Client extends BaseClient
{
    protected $needGateway = true;

    /**
     * 销售出库单列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function saleOutWareHouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/salesdelivery/list', $params);
    }

    /**
     * 采购单入库
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseInWarehouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/purchasereceipt/list', $params);
    }

    /**
     * 手动入库单
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException]
     */
    public function otherWarehouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/miscellaneousreceipt/list', $params);
    }

    /**
     * 其他出库单
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function otherExWarehouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/miscellaneousdelivery/list', $params);
    }

    /**
     * 产品入库仓
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function productWarehouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/productreceipt/list', $params);
    }

    /**
     * 生产领料单列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function producePickingList($page = 1 ,$pageSize =20,$accountDb= '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != ''){
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/app007104/api/pickinglist/list',$params);
    }

}
