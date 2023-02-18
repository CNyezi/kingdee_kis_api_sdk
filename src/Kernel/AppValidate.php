<?php

namespace Holt\KindeeKis\Kernel;

use Holt\KindeeKis\Kernel\Contracts\AppValidateInterface;
use Holt\KindeeKis\Kernel\Support\Str;
use Holt\KindeeKis\Kernel\Traits\HasHttpRequests;
use Holt\KindeeKis\Kernel\Traits\InteractsWithCache;
use Psr\Http\Message\RequestInterface;
use function Holt\KindeeKis\Kernel\Support\str_random;

 class AppValidate implements AppValidateInterface
{

    use HasHttpRequests;
    use InteractsWithCache;

    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge([
            'client_id' => $this->app['config']['app_id'],
            'client_secret' => $this->app['config']['app_secret']
        ], $query));


        return $request->withUri($request->getUri()->withQuery($query))
            ->withHeader('KIS-Timestamp', time())
            ->withHeader('KIS-State', Str::random(16))
            ->withHeader('KIS-TraceID', Str::random(30))
            ->withHeader('KIS-Ver', '1.0')
            ->withHeader('Content-Type', 'application/json');
    }

}