<?php

namespace Holt\KindeeKis\Apis\Kis\BaseInfo;

use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Events\HttpResponseCreated;

class Client extends BaseClient
{

    protected $needGateway = true;

    public function getBaseInfoList($baseId, $fItemClassID, $fParentID = null, $pageSize = 20, $page = 1)
    {
        $params = [
            'Data' => [
                'BaseID' => $baseId,
                'Para' => [
                    'FItemClassID' => $fItemClassID,
                ],
                'pageInfo' => [
                    'ItemsOfPage' => $pageSize,
                    'CurrentPage' => $page
                ]
            ]
        ];
        if (isset($fParentID)) {
            $params['Data']['Para']                   ['FParentID'] = $fParentID;

        }
        return $this->httpPostJson('/koas/SVC200000/goodsmanage/ItemInfo/GetBaseInfo', $params);
    }

    public function getSupplierList($page = 1, $pageSize = 20, $parentId = 0,
                                    $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '')
    {
        return $this->httpPostJson('/koas/APP006992/api/Vendor/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ]);
    }


    /**
     * 批量查询核算项目信息详情
     *
     * https://open.jdy.com/#/files/api/detail?index=2&categrayId=dded94c553614747b2c9b8b49c396aa6&id=a75638a6753711ed86f7f51a4d6b3fcf
     * @param $pageSize
     * @param $page
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getAccountingItemList($page = 1, $pageSize = 20)
    {
        return $this->httpPostJson('/koas/APP006992/api/AccountingItem/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page
        ]);
    }


    /**
     * 批量查询科目基础资料详情
     * https://open.jdy.com/#/files/api/detail?index=2&categrayId=dded94c553614747b2c9b8b49c396aa6&id=f20e1b93754411ed86f7cd9be24e977c
     *
     * @param $page
     * @param $pageSize
     * @param $ids
     * @param $startDate
     * @param $endDate
     * @return array|\Holt\KindeeKis\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException
     */
    public function getAccountList($page = 1, $pageSize = 20, $ids = [], $startDate = '', $endDate = '')
    {
        return $this->httpPostJson('/koas/APP006992/api/Account/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ]);
    }


    public function getDepartmentList($page = 1, $pageSize = 20, $parentId = 0,
                                      $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '')
    {
        return $this->httpPostJson('/koas/APP006992/api/Department/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ]);
    }


    public function getEmployeeList($page = 1, $pageSize = 20, $parentId = 0,
                                    $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '')
    {
        return $this->httpPostJson('/koas/APP006992/api/Employee/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate,
            "FItemClassID" => 2
        ]);
    }

}