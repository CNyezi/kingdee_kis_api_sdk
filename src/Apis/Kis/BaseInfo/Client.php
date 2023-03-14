<?php

namespace Holt\KindeeKis\Apis\Kis\BaseInfo;

use GuzzleHttp\Exception\GuzzleException;
use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Events\HttpResponseCreated;
use Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException;
use Holt\KindeeKis\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * 获取供应商资料列表
     * @param $page
     * @param $pageSize
     * @param $parentId
     * @param $detail
     * @param $searchKey
     * @param $ids
     * @param $startDate
     * @param $endDate
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
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
     * 获取供应商资料详情
     * @param $itemId
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getSupplierDetail($itemId = 0)
    {
        return $this->httpPostJson('/koas/APP006992/api/Vendor/Get', [
            'ItemId' => $itemId,
        ]);
    }

    /**
     * 获取结算方式列表
     * @param $page
     * @param $pageSize
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getSettleMethodList($page = 1, $pageSize = 20)
    {
        return $this->httpPostJson('/koas/APP006992/api/Settle/List', [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize
        ]);
    }


    /**
     * 获取物料分类列表
     * @param int $page
     * @param int $pageSize
     * @return array|string|Collection|ResponseInterface
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialCategoryList(int $page = 1, int $pageSize = 20)
    {
        return $this->httpPostJson('/koas/APP006992/api/MaterialCategory/List', [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize
        ]);
    }

    /**
     * 获取所有物料
     * @param $page
     * @param $pageSize
     * @param $parentId
     * @param $detail
     * @param $searchKey
     * @param $ids
     * @param $startDate
     * @param $endDate
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getAllMaterialList($page = 1, $pageSize = 20, $parentId = 0, $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '')
    {
        return $this->httpPostJson('/koas/APP006992/api/Material/List', [
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
     * 获取物料资料详情
     * @param $id
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialDetail($id = 0)
    {
        return $this->httpPostJson('/koas/APP006992/api/Material/Get', [
            'ItemId' => $id
        ]);
    }

    /**
     * 获取某个计量单位分组下的物料单位列表
     * @param $page
     * @param $pageSize
     * @param $groupId
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialUnitList($page = 1, $pageSize = 20, $groupId = 0)
    {
        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'FUnitGroupID' => $groupId
        ]);
    }

    /**
     * 获取计量单位分组列表
     * @param $page
     * @param $pageSize
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialUnitGroupList($page = 1, $pageSize = 20)
    {
        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/UnitGroupList', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page
        ]);

    }

    /**
     * 获取物料单位详情
     * @param $id
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialUnitDetail($id = 0)
    {
        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/GetDetail', [
            'FItemID' => $id
        ]);
    }

    /**
     * 批量查询核算项目信息详情
     *
     * https://open.jdy.com/#/files/api/detail?index=2&categrayId=dded94c553614747b2c9b8b49c396aa6&id=a75638a6753711ed86f7f51a4d6b3fcf
     * @param $pageSize
     * @param $page
     * @return array|Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getAccountingItemList($page = 1, $pageSize = 20)
    {
        return $this->httpPostJson('/koas/APP006992/api/AccountingItem/List', [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page
        ]);
    }

    /**
     * 查询库存
     * @param $page
     * @param $pageSize
     * @param $data
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getStockCount($page = 1, $pageSize = 20, $data = [])
    {
        return $this->httpPostJson('/koas/APP002112/uereport/UEStockController/SearchItemInfors', [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
            'Data' => [
                "GName" => "",
                "GCode" => "",
                "GHelpCode" => "",
                "GBatchNo" => "",
                "GStockCode" => "",
                "SearchTop" => "",
                "GModel" => ""
            ],
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
     * @return array|Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
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

    public function getEmployeeDetail($itemId)
    {
        return $this->httpPostJson('/koas/APP006992/api/Employee/Get', [
            "ItemId" => $itemId
        ]);
    }

}