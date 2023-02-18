<?php

namespace Holt\KindeeKis\Kernel\Contracts;

use Psr\Http\Message\RequestInterface;

interface GatewayInterface
{

    public function setUpGateway($gatewayData);

    public function getGatewayInfo();

    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;
}