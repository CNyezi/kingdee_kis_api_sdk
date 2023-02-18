<?php

namespace Holt\KindeeKis\Apis\Kis\Account;

use Holt\KindeeKis\Kernel\BaseClient;

class Client extends BaseClient
{
    public function getAccountsList()
    {
        return $this->httpPostJson('/koas/user/account');
    }


    public function getAndSetUpAccountGateway($pid, $acctnumber, $icrmid)
    {
        $response = $this->httpPostJson('/koas/user/get_service_gateway', [
            'pid' => $pid,
            'acctnumber' => $acctnumber,
            'icrmid' => $icrmid
        ]);
        if ($response['errcode'] == '0') {
            $this->app->gateway->setUpGateway($response['data']);
        }
        return $response['data'];
    }


    public function getAppList($acctnumber, $pid)
    {
        return $this->httpPostJson('/koas/user/account_applist', [
            'pid' => $pid,
            'acctnumber' => $acctnumber,
            'client_id' => $this->app['config']['app_id']
        ]);
    }

}