<?php

namespace Holt\KindeeKis\Apis\Kis;


use Exception;
use Holt\KindeeKis\Apis\Constant;
use Holt\KindeeKis\Apis\Kis\BaseInfo\Client;
use Holt\KindeeKis\Apis\Kis\BaseInfo\ServiceProvider;
use Holt\KindeeKis\Kernel\Exceptions\NeedLoginException;
use Holt\KindeeKis\Kernel\ServiceContainer;
use Pimple\ServiceProviderInterface;

/**
 *  * @property Login\Client $login
 *  * @property Account\Client $account
 * @property Client $baseInfo
 * @property \Holt\KindeeKis\Apis\Kis\Pay\Client $pay
 * @property \Holt\KindeeKis\Apis\Kis\Sale\Client $sale
 * @property \Holt\KindeeKis\Apis\Kis\Stock\Client $stock
 * @property \Holt\KindeeKis\Apis\Kis\Purchase\Client $purchase
 * @property \Holt\KindeeKis\Apis\Kis\Voucher\Client $voucher
 */
class Application extends ServiceContainer
{


    protected array $providers = [
        Login\ServiceProvider::class,
        Account\ServiceProvider::class,
        ServiceProvider::class,
        Pay\ServiceProvider::class,
        Sale\ServiceProvider::class,
        Stock\ServiceProvider::class,
        Purchase\ServiceProvider::class,
        Voucher\ServiceProvider::class,
    ];

    public function checkKisAuthStatus()
    {
        try {
            $token = $this->access_token->getToken();
            if ($token && $token['access_token_expire_in'] < time() + 2 * 86400) {
                $this->access_token->refresh();
            }
            $gateway = $this->gateway->getGatewayInfo();
            if (!$gateway) {
                return Constant::LOGIN_STATUS_NEED_CHOOSE_ACCOUNT;
            }
            return Constant::LOGIN_STATUS_OK;
        } catch (NeedLoginException $e) {
            return Constant::LOGIN_STATUS_NEED_LOGIN;
        }
    }


}