<?php

namespace Holt\KindeeKis\Apis;

use GuzzleHttp\Exception\GuzzleException;
use Holt\KindeeKis\Kernel\Exceptions\InvalidArgumentException;
use Holt\KindeeKis\Kernel\Support\Str;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AccessToken extends \Holt\KindeeKis\Kernel\AccessToken
{

    protected $endpointToGetToken = '/koas/user/refresh_login_access_token';

    protected function getCredentials(): array
    {
        return [
            'session_id' => '',
            'access_token' => $this->getLastToken()
        ];
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
        $lastData = $this->getToken();
        $options = [
            'json' => ['session_id' => $lastData['session_id']],
            'query' => ['access_token' => $lastData['access_token']],
            'headers' => [
                'KIS-Timestamp' => time(),
                'KIS-State' => Str::random(16),
                'KIS-TraceID' => Str::random(32),
                'KIS-Ver' => '1.0',
                'Content-Type' => 'application/json'
            ]
        ];

        return $this->setHttpClient($this->app['http_client'])
            ->request($this->getEndpoint(), $this->requestMethod, $options);
    }
}