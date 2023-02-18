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
use GuzzleHttp\Exception\GuzzleException;
use Holt\KindeeKis\Kernel\Contracts\AccessTokenInterface;
use Holt\KindeeKis\Kernel\Exceptions\HttpException;
use Holt\KindeeKis\Kernel\Exceptions\InvalidArgumentException;
use Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException;
use Holt\KindeeKis\Kernel\Exceptions\NeedLoginException;
use Holt\KindeeKis\Kernel\Exceptions\RuntimeException;
use Holt\KindeeKis\Kernel\Support\Collection;
use Holt\KindeeKis\Kernel\Traits\HasHttpRequests;
use Holt\KindeeKis\Kernel\Traits\InteractsWithCache;
use http\Message\Body;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
abstract class AccessToken implements AccessTokenInterface
{
    use HasHttpRequests;
    use InteractsWithCache;

    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'kingdee.kernel.access_token.';


    protected $sessionId = 'session_id';
    protected $cacheSessionPrefix = 'kingdee.kernel.session_id.';

    /**
     * AccessToken constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    public function getLastToken()
    {
        return $this->token;
    }

    /**
     * @return array
     *
     * @throws HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRefreshedToken(): array
    {
        return $this->getToken(true);
    }

    /**
     * @param bool $refresh
     *
     * @return array
     *
     * @throws HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey) && $result = $cache->get($cacheKey)) {
            return $result;
        }
        if (!$cache->has($cacheKey)) {
            throw new NeedLoginException('请重新登录');
        }

        /** @var array $token */
        $token = $this->requestToken($this->getCredentials(), true);
        $token = $token['data'];
        $this->setToken($token, 10800);

        $this->token = $token;

        $this->app->events->dispatch(new Events\AccessTokenRefreshed($this));

        return $token;
    }

    /**
     * @param string $token
     * @param int $lifetime
     *
     * @return AccessTokenInterface
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setToken(array $accessTokenData, int $lifetime = 7200): AccessTokenInterface
    {
        $accessTokenData['expires_in'] = $lifetime;
        $this->getCache()->set($this->getCacheKey(), $accessTokenData, $lifetime);
        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache access token.');
        }

        return $this;
    }

    /**
     * @return AccessTokenInterface
     *
     * @throws HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function refresh(): AccessTokenInterface
    {
        $this->getToken(true);

        return $this;
    }

    /**
     * @param array $credentials
     * @param bool $toArray
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);
        $formatted = $this->castResponseToType($response, $this->app['config']->get('response_type'));

        if (empty($result['data'][$this->tokenKey])) {
            throw new HttpException('Request access_token fail: ' . json_encode($result, JSON_UNESCAPED_UNICODE), $response, $formatted);
        }

        return $toArray ? $result : $formatted;
    }

    /**
     * @param RequestInterface $request
     * @param array $requestOptions
     *
     * @return RequestInterface
     *
     * @throws HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge($this->getQuery(), $query));

        return $request->withUri($request->getUri()->withQuery($query));
    }

    /**
     * Send http request.
     *
     * @param array $credentials
     *
     * @return ResponseInterface
     *
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function sendRequest(array $credentials): ResponseInterface
    {
        $options = [
            'json' => ['session_id' => $credentials['session_id']],
        ];
        return $this->setHttpClient($this->app['http_client'])
            ->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     */
    protected function getCacheKey(): string
    {
        return $this->cachePrefix . $this->app['config']['company_id'] . '.' . md5(json_encode($this->getCredentials()));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @return array
     *
     * @throws HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->getToken()[$this->tokenKey]];
    }

    /**
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getEndpoint(): string
    {
        if (empty($this->endpointToGetToken)) {
            throw new InvalidArgumentException('No endpoint for access token request.');
        }

        return $this->endpointToGetToken;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}
