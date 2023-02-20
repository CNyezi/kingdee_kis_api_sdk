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

use Closure;
use GuzzleHttp\Exception\GuzzleException;
use Holt\KindeeKis\Kernel\Contracts\AccessTokenInterface;
use Holt\KindeeKis\Kernel\Contracts\AppValidateInterface;
use Holt\KindeeKis\Kernel\Exceptions\InvalidConfigException;
use Holt\KindeeKis\Kernel\Http\Response;
use Holt\KindeeKis\Kernel\Support\Collection;
use Holt\KindeeKis\Kernel\Traits\HasHttpRequests;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;

/**
 * Class BaseClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var ServiceContainer
     */
    protected $app;
    /**
     * @var AccessTokenInterface|null
     */
    protected $accessToken = null;


    protected $needGateway = false;
    /**
     * @var AppValidateInterface
     */
    protected $headerDeal = null;
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * BaseClient constructor.
     *
     * @param ServiceContainer $app
     * @param AccessTokenInterface|null $accessToken
     */
    public function __construct(ServiceContainer $app, AccessTokenInterface $accessToken = null)
    {
        $this->app = $app;
        $this->accessToken = $accessToken ?? $this->app['access_token'];
        $this->headerDeal = $this->app['common_header_deal'];
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array $query
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * POST request.
     *
     * @param string $url
     * @param array $data
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * JSON request.
     *
     * @param string $url
     * @param array $data
     * @param array $query
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * Upload file.
     *
     * @param string $url
     * @param array $files
     * @param array $form
     * @param array $query
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function httpUpload(string $url, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];
        $headers = [];

        if (isset($form['filename'])) {
            $headers = [
                'Content-Disposition' => 'form-data; name="media"; filename="' . $form['filename'] . '"'
            ];
        }

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
                'headers' => $headers
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request(
            $url,
            'POST',
            ['query' => $query, 'multipart' => $multipart, 'connect_timeout' => 30, 'timeout' => 30, 'read_timeout' => 30]
        );
    }

    /**
     * @return AccessTokenInterface
     */
    public function getAccessToken(): AccessTokenInterface
    {
        return $this->accessToken;
    }

    /**
     * @param AccessTokenInterface $accessToken
     *
     * @return $this
     */
    public function setAccessToken(AccessTokenInterface $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @param bool $returnRaw
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }


        if (isset($options['json'])) {
            $options['json']['session_id'] = $this->getAccessToken()->getToken()['session_id'];
        } else {
            $options['json'] = ['session_id' => $this->getAccessToken()->getToken()['session_id']];
        }

        $response = $this->performRequest($url, $method, $options);

        $this->app->events->dispatch(new Events\HttpResponseCreated($response));

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     *
     * @return Response
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function requestRaw(string $url, string $method = 'GET', array $options = [])
    {
        return Response::buildFromPsrResponse($this->request($url, $method, $options, true));
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares($withAccessToken = true)
    {
        // retry
        $this->pushMiddleware($this->retryMiddleware(), 'retry');
        // access token
        if ($withAccessToken) {
            $this->pushMiddleware($this->accessTokenMiddleware(), 'access_token');
        }
        if (isset($this->app['gateway']) && $this->needGateway){
            $this->pushMiddleware($this->gatewayMiddleware(), 'gateway');
        }

        $this->pushMiddleware($this->headerAppIdMiddleware(), 'common');
        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
    }

    /**
     * Attache access token to request query.
     *
     * @return Closure
     */
    protected function accessTokenMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->accessToken) {
                    $request = $this->accessToken->applyToRequest($request, $options);
                }
                return $handler($request, $options);
            };
        };
    }

    protected function gatewayMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->app->gateway && $this->app->gateway->issetGatewayInfo()) {
                    $request = $this->app->gateway->applyToRequest($request, $options);
                }
                return $handler($request, $options);
            };
        };
    }

    protected function headerAppIdMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->headerDeal) {
                    $request = $this->headerDeal->applyToRequest($request, $options);
                }
                return $handler($request, $options);
            };
        };
    }


    /**
     * Log the request.
     *
     * @return Closure
     */
    protected function logMiddleware()
    {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ?? MessageFormatter::DEBUG);

        return Middleware::log($this->app['logger'], $formatter, LogLevel::DEBUG);
    }

    /**
     * Return retry middleware.
     *
     * @return Closure
     */
    protected function retryMiddleware()
    {
        return Middleware::retry(
            function (
                $retries,
                RequestInterface $request,
                ResponseInterface $response = null
            ) {
                // Limit the number of retries to 2
                if ($retries < $this->app->config->get('http.max_retries', 1) && $response && $body = $response->getBody()) {
                    // Retry on server errors
                    $response = json_decode($body, true);

                    if (!empty($response['errcode']) && in_array(abs($response['errcode']), [40001, 40014, 42001], true)) {
                        $this->accessToken->refresh();
                        $this->app['logger']->debug('Retrying with refreshed access token.');

                        return true;
                    }
                }

                return false;
            },
            function () {
                return abs($this->app->config->get('http.retry_delay', 500));
            }
        );
    }
}
