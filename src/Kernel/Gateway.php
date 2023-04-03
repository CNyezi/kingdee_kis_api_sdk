<?php

namespace Holt\KindeeKis\Kernel;

use Holt\KindeeKis\Kernel\Contracts\GatewayInterface;
use Holt\KindeeKis\Kernel\Exceptions\RuntimeException;
use Holt\KindeeKis\Kernel\Support\Str;
use Holt\KindeeKis\Kernel\Traits\InteractsWithCache;
use Psr\Http\Message\RequestInterface;

abstract class Gateway implements GatewayInterface
{
    use InteractsWithCache;


    /**
     * @var ServiceContainer
     */
    protected $app;

    protected $cacheKeyPrefix;

    /**
     * Gateway constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->cacheKeyPrefix = 'holt.kis_gateway.';
    }


    public function setUpGateway($gatewayData)
    {
        $cacheKey = $this->getCacheKey();
        $cacheData = [
            'gateway' => $gatewayData['gateway'],
            'auth_data' => $gatewayData['auth_data'],
            'gw_router_addr' => $gatewayData['gw_router_addr'],
            'refresh_auth_data_token' => '',
            'refresh_auth_data_token_expire_in' => ''
        ];
        $this->getCache()->set($cacheKey, $cacheData,   9999999);

        if (!$this->getCache()->has($cacheKey)) {
            throw new RuntimeException('Failed to cache gateway info.');
        }
        return $this;
    }

    protected function getCacheKey()
    {
        return $this->cacheKeyPrefix . $this->app->config['company_id'];
    }

    public function getGatewayInfo()
    {
        $cache = $this->getCache();
        var_dump($cache);
        $cacheKey = $this->getCacheKey();
        if ($cache->has($cacheKey) && $result = $cache->get($cacheKey)) {
            return $result;
        }
        return null;
    }

    public function deleteCurrentCache()
    {
        return $this->getCache()->delete($this->getCacheKey());
    }

    public function issetGatewayInfo()
    {
        return $this->getCache()->has($this->getCacheKey());
    }

    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge([
            'client_id' => $this->app['config']['app_id'],
            'client_secret' => $this->app['config']['app_secret']
        ], $query));


        $gateway = $this->getGatewayInfo();
        return $request->withUri($request->getUri()->withQuery($query))
            ->withHeader('KIS-Timestamp', time())
            ->withHeader('KIS-State', Str::random(16))
            ->withHeader('KIS-TraceID', Str::random(30))
            ->withHeader('KIS-Ver', '1.0')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('KIS-AuthData', $gateway['auth_data'])
            ->withHeader('X-GW-Router-Addr', $gateway['gw_router_addr']);

    }
}