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

interface AppValidateInterface
{
    /**
     * @param RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;
}
