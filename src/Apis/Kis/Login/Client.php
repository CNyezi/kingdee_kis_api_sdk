<?php

namespace Holt\KindeeKis\Apis\Kis\Login;

use Holt\KindeeKis\Kernel\BaseClient;
use Holt\KindeeKis\Kernel\Events\HttpResponseCreated;

class Client extends BaseClient
{


    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares(false);
        }

        $response = $this->performRequest($url, $method, $options);

        $this->app->events->dispatch(new HttpResponseCreated($response));

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    public function loginWithCode($phone, $code)
    {
        $response = $this->httpPostJson('/koas/user/sms_login_access_token', [
            'mobile' => $phone,
            'vcode' => $code
        ]);
        if ($response['errcode'] == 0) {
            $this->app->access_token->setToken($response['data'], 10800);
        }
        return $response;

        /**
         *
         * 'uid' =>
         * int(144295042)
         * 'nickname' =>
         * string(6) "芒种"
         * 'avatar' =>
         * string(75) "https://static.yunzhijia.com/space/c/photo/load?id=63bcc72189e8710001080c95"
         * 'access_token' =>
         * string(32) "1676338478f090c131eabcd106bdb54f"
         * 'access_token_expire_in' =>
         * int(1679021401)
         * 'session_id' =>
         * string(32) "se1676429402wjrlnkqionibkcmrqjjx"
         * 'session_id_expire_in' =>
         * int(1676440202)
         * 'session_secret' =>
         * string(32) "hrurmauromvhzgllapugidhvgpuuouof"
         */
    }

    public function getSmsCode($phone)
    {
        return $this->httpPostJson('/koas/user/sms_login_vcode', [
            'mobile' => $phone
        ]);
    }


}