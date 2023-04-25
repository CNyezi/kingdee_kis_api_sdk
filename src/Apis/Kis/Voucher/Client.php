<?php

namespace Holt\KindeeKis\Apis\Kis\Voucher;

use Holt\KindeeKis\Kernel\BaseClient;

class Client extends BaseClient
{
    protected $needGateway = true;

    /**
     * 获取凭证列表
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getVoucherList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP007155/api/Voucher/List', $params);
    }

    /**
     * 获取凭证字列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getVoucherGroupList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/VoucherGroup/List', $params);
    }


    /**
     * 新增凭证
     * @param $head
     * @param $entryList
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function createVoucher($head, $entryList, $accountDb = '')
    {
        $params = [
            "Head" => $head,
            "Entries" => $entryList
        ];

        if ($accountDb != '') {
            $params['accountDb'] = $accountDb;
        }


        return $this->httpPostJson('/koas/APP007155/api/Voucher/Create', $params);
    }

    /**
     * 获取会计科目
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getAccountList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Account/List', $params);
    }

    /**
     * 获取会计科目详情
     * @param $page
     * @param $pageSize
     * @param $ids
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getAccountDetail($accountId , $accountDb = '')
    {
        $params = [
            'FAccountId' => $accountId,
            'ShowItems' => true,
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }
        return $this->httpPostJson('/koas/APP006992/api/Account/GetDetail', $params);
    }

    /**
     * 获取凭证详情
     * @param $id
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getVoucherDetail($id, $accountDb = '')
    {
        $params = [
            'FVoucherID' => $id,
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP007155/api/Voucher/GetDetail', $params);
    }

    /**
     * 获取币别列表
     * @param $page
     * @param $pageSize
     * @param $ids
     * @param $accountDb
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getCurrencyList($page = 1, $pageSize = 20, $ids = [], $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
            'Ids' => $ids
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Currency/List', $params);
    }
}