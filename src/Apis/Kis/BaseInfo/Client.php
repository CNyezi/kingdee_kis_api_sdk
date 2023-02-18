<?php

namespace Holt\KindeeKis\Apis\Kis\BaseInfo;

use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Events\HttpResponseCreated;

class Client extends BaseClient
{


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


}