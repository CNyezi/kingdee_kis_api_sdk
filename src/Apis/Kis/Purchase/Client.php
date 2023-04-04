<?php

namespace Holt\KindeeKis\Apis\Kis\Purchase;

use Holt\KindeeKis\Kernel\BaseClient;

class Client extends BaseClient
{
    protected $needGateway = true;


    /**
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseOrderList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/poorder/list',$params);
    }

    /**
     * 采购计划单
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchasePlanList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/porequest/list',$params);
    }

    /**
     * 采购退货单列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseReturnList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/materialreturnnotice/list',$params);
    }

    /**
     * 采购普票列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseGeneralTicketList($page = 1, $pageSize = 20,$accountDb='')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/purchaseinvoicecommon/list',$params);
    }

    /**
     * 采购专票列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseSpecialTicketList($page = 1, $pageSize= 20,$accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/purchaseinvoicevat/list',$params);
    }


    /**
     * 采购单质检单列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseQualityList($page = 1, $pageSize = 20,$accountDb = '')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb != ''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/purchasequality/list',$params);
    }

    /**
     * 采购单不良原因列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function purchaseUnQualityList($page =1 ,$pageSize =20,$accountDb='')
    {
        $params=[
            'CurrentPage' => $page,
            'ItemsOfPage'=>$pageSize
        ];

        if ($accountDb !=''){
            $params['AccountDb']=$accountDb;
        }

        return $this->httpPostJson('/koas/app007140/api/qualitydefect/list',$params);
    }



}