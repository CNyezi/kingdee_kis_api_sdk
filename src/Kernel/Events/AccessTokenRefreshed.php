<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Holt\KindeeKis\Kernel\Events;

use Holt\KindeeKis\Kernel\AccessToken;

/**
 * Class AccessTokenRefreshed.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessTokenRefreshed
{
    /**
     * @var AccessToken
     */
    public $accessToken;

    /**
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
