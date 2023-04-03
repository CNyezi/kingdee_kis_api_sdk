<?php

namespace Holt\KindeeKis\Apis\Kis\Sale;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Holt\KindeeKis\Apis\AccessToken;
use Holt\KindeeKis\Apis\Gateway;
use Holt\KindeeKis\Kernel\AppValidate;


class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        !isset($app['access_token']) && $app['access_token'] = function ($app) {
            return new AccessToken($app);
        };
        !isset($app['common_header_deal']) && $app['common_header_deal'] = function ($app) {
            return new AppValidate($app);
        };
        !isset($app['gateway']) && $app['gateway'] = function ($app) {
            return new Gateway($app);
        };
        !isset($app['baseInfo']) && $app['baseInfo'] = function ($app) {
            return new Client($app);
        };
    }
}