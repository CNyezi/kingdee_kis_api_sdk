<?php

namespace Holt\KindeeKis\Apis\Kis\BaseInfo;

use GuzzleHttp\Exception\GuzzleException;
use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException;
use Holt\KindeeKis\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{

    protected $needGateway = true;

    public function getBaseInfoList($baseId, $fItemClassID, $fParentID = null, $pageSize = 20, $page = 1, $accountDb = '')
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
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }
        return $this->httpPostJson('/koas/SVC200000/goodsmanage/ItemInfo/GetBaseInfo', $params);
    }

    //带分页
    // array(12) {
    //        ["FDetail"]=>
    //        bool(true)
    //        ["FFullName"]=>
    //        string(61) "自动化零件类_东莞市可川自动化设备有限公司"
    //        ["FFullNumber"]=>
    //        string(7) "02.0016"
    //        ["FItemClassID"]=>
    //        int(8)
    //        ["FItemID"]=>
    //        int(374)
    //        ["FLevel"]=>
    //        int(2)
    //        ["FModifyTime"]=>
    //        string(19) "2022-10-09T13:50:06"
    //        ["FName"]=>
    //        string(42) "东莞市可川自动化设备有限公司"
    //        ["FNumber"]=>
    //        string(7) "02.0016"
    //        ["FParentID"]=>
    //        int(16064)
    //        ["FShortNumber"]=>
    //        string(4) "0016"
    //        ["UUID"]=>
    //        string(36) "96f5f9a1-e383-40cc-a8b7-4b8fc0a7c24d"
    //      }
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
                                    $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '', $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Vendor/List', $params);
    }


    /**
     * 获取供应商资料详情
     * @param $itemId
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getSupplierDetail($itemId = 0, $accountDb = '')
    {
        $params = [
            'ItemId' => $itemId,
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }
        return $this->httpPostJson('/koas/APP006992/api/Vendor/Get', $params);
    }

    /**
     * 获取结算方式列表
     * @param $page
     * @param $pageSize
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getSettleMethodList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Settle/List', $params);
    }


    // array(12) {
    //        ["FDetail"]=>
    //        bool(true)
    //        ["FFullName"]=>
    //        string(53) "工厂自动化零件_直线运动零件_直线轴承"
    //        ["FFullNumber"]=>
    //        string(8) "01.01.04"
    //        ["FItemClassID"]=>
    //        int(2037)
    //        ["FItemID"]=>
    //        int(587)
    //        ["FLevel"]=>
    //        int(3)
    //        ["FModifyTime"]=>
    //        string(19) "2022-10-11T12:03:10"
    //        ["FName"]=>
    //        string(12) "直线轴承"
    //        ["FNumber"]=>
    //        string(8) "01.01.04"
    //        ["FParentID"]=>
    //        int(262)
    //        ["FShortNumber"]=>
    //        string(2) "04"
    //        ["UUID"]=>
    //        string(36) "367e99b1-9a02-4172-a6ac-c3e34cbf54d8"
    //      }
    /**
     * 获取物料分类列表
     * @param int $page
     * @param int $pageSize
     * @return array|string|Collection|ResponseInterface
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialCategoryList(int $page = 1, int $pageSize = 20, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/MaterialCategory/List', $params);
    }

    // array(12) {
    //        ["FDetail"]=>
    //        bool(true)
    //        ["FFullName"]=>
    //        string(21) "高速旋转连接件"
    //        ["FFullNumber"]=>
    //        string(15) "A1-BP-3-00074A0"
    //        ["FItemClassID"]=>
    //        int(4)
    //        ["FItemID"]=>
    //        int(23722)
    //        ["FLevel"]=>
    //        int(1)
    //        ["FModifyTime"]=>
    //        string(19) "2022-10-31T09:04:57"
    //        ["FName"]=>
    //        string(21) "高速旋转连接件"
    //        ["FNumber"]=>
    //        string(15) "A1-BP-3-00074A0"
    //        ["FParentID"]=>
    //        int(0)
    //        ["FShortNumber"]=>
    //        string(15) "A1-BP-3-00074A0"
    //        ["UUID"]=>
    //        string(36) "86c948b6-4409-4227-9066-a41b87ba6be4"
    //      }
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
    public function getAllMaterialList($page = 1, $pageSize = 20, $parentId = 0, $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '', $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }
        return $this->httpPostJson('/koas/APP006992/api/Material/List', $params);
    }

    /**
     * 获取物料资料详情
     * @param $id
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialDetail($id = 0, $accountDb = '')
    {
        $params = [
            'ItemId' => $id
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Material/Get', $params);
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
    public function getMaterialUnitList($page = 1, $pageSize = 20, $groupId = 0, $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'FUnitGroupID' => $groupId
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/List', $params);
    }

    /**
     * 获取计量单位分组列表
     * @param $page
     * @param $pageSize
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialUnitGroupList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }


        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/UnitGroupList', $params);

    }

    /**
     * 获取所有仓库列表
     * @param $page
     * @param $pageSize
     * @param $accountDb
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function storeHouseList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => 0,
            'Detail' => true,
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Stock/List', $params);
    }


    /**
     * 获取物料单位详情
     * @param $id
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getMaterialUnitDetail($id = 0, $accountDb = '')
    {
        $params = [
            'FItemID' => $id
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/MeasureUnit/GetDetail', $params);
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
    public function getAccountingItemList($page = 1, $pageSize = 20, $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/AccountingItem/List', $params);
    }

    /**
     * 查询库存列表
     * @param $page
     * @param $pageSize
     * @param $data
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getStockCount($page = 1, $pageSize = 1, $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
            'Data' => [
                'GName' => '',
                'GCode' => '',
                'GHelpCode' => '',
                'GBatchNo' => '',
                'GStockCode' => '',
                'SearchTop' => '',
                'GModel' => ''
            ],
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }


        return $this->httpPostJson('/koas/APP002112/uereport/UEStockController/SearchItemInfors', $params);
    }

    /**
     * 获取仓库列表信息
     * @param $page
     * @param $pageSize
     * @param $data
     * @param $accountDb
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getStoreHouseList($page = 1, $pageSize = 20, $data = [], $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
            'Data' => [
            ],
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }


        return $this->httpPostJson('koas/APP002112/uereport/UEStockController/GetStockInfors', $params);
    }


    /**
     * 获取物料详细仓库信息
     * @param $page
     * @param $pageSize
     * @param $materialId
     * @param $stockId
     * @param $accountDb
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function GetItemStockInfo($page = 1, $pageSize = 2, $materialId = '', $stockId = '', $accountDb = '')
    {
        $params = [
            'CurrentPage' => $page,
            'ItemsOfPage' => $pageSize,
            'Data' => [
                'FItemID' => $materialId,
                'FStockID' => $stockId,
            ],
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP002112/uereport/UEStockController/GetItemStockInfors', $params);
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
    public function getAccountList($page = 1, $pageSize = 20, $ids = [], $startDate = '', $endDate = '', $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Account/List', $params);
    }


    public function getDepartmentList($page = 1, $pageSize = 20, $parentId = 0, $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '', $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Department/List', $params);
    }


    public function getEmployeeList($page = 1, $pageSize = 20, $parentId = 0, $detail = true, $searchKey = '', $ids = [], $startDate = '', $endDate = '', $accountDb = '')
    {
        $params = [
            'ItemsOfPage' => $pageSize,
            'CurrentPage' => $page,
            'ParentId' => $parentId,
            'Detail' => $detail,
            'SearchKey' => $searchKey,
            'Ids' => $ids,
            'StartDate' => $startDate,
            'EndDate' => $endDate,
            "FItemClassID" => 2
        ];
        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }


        return $this->httpPostJson('/koas/APP006992/api/Employee/List', $params);
    }

    public function getEmployeeDetail($itemId, $accountDb = '')
    {
        $params = [
            "ItemId" => $itemId

        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Employee/Get', $params);
    }

    /**
     * 获取客户列表
     * @param $page
     * @param $pageSize
     * @param $parentId
     * @param $accountDb
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function CustomerList($page = 1, $pageSize = 20, $parentId = 0, $accountDb = '')
    {
        $params = [
            "CurrentPage" => $page,
            "ItemsOfPage" => $pageSize,
            "ParentId" => $parentId,
            "Detail" => true,
            "SearchKey" => '',
            "Ids" => [],
            "StartDate" => "",
            "EndDate" => ""
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Customer/List', $params);
    }

    /**
     * 获取客户详情
     * @param $id
     * @param $accountDb
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function customerDetail($id, $accountDb = '')
    {
        $params = [
            "ItemId" => $id
        ];

        if ($accountDb != '') {
            $params['AccountDb'] = $accountDb;
        }

        return $this->httpPostJson('/koas/APP006992/api/Customer/Get', $params);
    }

}
