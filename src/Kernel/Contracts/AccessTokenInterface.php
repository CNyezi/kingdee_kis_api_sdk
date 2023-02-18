<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Holt\KindeeKis\Kernel\Contracts;

use Psr\Http\Message\RequestInterface;

/**
 * Interface AuthorizerAccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
interface AccessTokenInterface
{
    /**
     * @return array
     */
    public function getToken(): array;


    /**
     * @return AccessTokenInterface
     */
    public function refresh(): self;

    /**
     * @param RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;
}
