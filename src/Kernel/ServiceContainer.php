<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Holt\KindeeKis\Kernel;

use GuzzleHttp\Client;
use Holt\KindeeKis\Kernel\Exceptions\Exception;
use Holt\KindeeKis\Kernel\Providers\ConfigServiceProvider;
use Holt\KindeeKis\Kernel\Providers\EventDispatcherServiceProvider;
use Holt\KindeeKis\Kernel\Providers\HttpClientServiceProvider;
use Holt\KindeeKis\Kernel\Providers\LogServiceProvider;
use Holt\KindeeKis\Kernel\Providers\RequestServiceProvider;
use Monolog\Logger;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServiceContainer.
 * @property Config $config
 * @property Request $request
 * @property Client $http_client
 * @property Logger $logger
 * @property EventDispatcher $events
 * @property \Holt\KindeeKis\Apis\AccessToken $access_token
 * @property \Holt\KindeeKis\Apis\Gateway $gateway
 */
class ServiceContainer extends Container
{

    protected array $providers = [];
    protected array $userConfig = [];
    protected array $defaultConfig = [];
    protected $id;


    public function __construct(array $config = [], array $prepends = [], string $id = null)
    {
        if (empty($config['company_id'])) {
            throw new Exception('公司id必须设置在配置中');
        }
        $this->userConfig = $config;
        parent::__construct($prepends);
        $this->registerProviders($this->getProviders());
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://api.kingdee.com',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders(): array
    {
        return array_merge([
            ConfigServiceProvider::class,
            LogServiceProvider::class,
            RequestServiceProvider::class,
            HttpClientServiceProvider::class,
            EventDispatcherServiceProvider::class,
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id ?? $this->id = md5(json_encode($this->userConfig));
    }
}
