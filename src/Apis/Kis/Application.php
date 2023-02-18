<?php

namespace Holt\KindeeKis\Apis\Kis;


use Holt\KindeeKis\Apis\Kis\BaseInfo\Client;
use Holt\KindeeKis\Apis\Kis\BaseInfo\ServiceProvider;
use Holt\KindeeKis\Kernel\ServiceContainer;
use Pimple\ServiceProviderInterface;

/**
 *  * @property Login\Client $login
 *  * @property Account\Client $account
 * @property Client $baseInfo
 * @property \Holt\KindeeKis\Apis\Kis\Pay\Client $pay
 */
class Application extends ServiceContainer
{


    protected array $providers = [
        Login\ServiceProvider::class,
        Account\ServiceProvider::class,
        ServiceProvider::class,
        Pay\ServiceProvider::class
    ];



}