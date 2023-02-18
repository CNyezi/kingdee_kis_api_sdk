<?php

namespace Holt\KindeeKis;


use Holt\KindeeKis\Kernel\ServiceContainer;
use Holt\KindeeKis\Kernel\Support\Str;


/**
 * Class Factory.
 *
 * @method static \Holt\KindeeKis\Apis\Kis\Application            kis(array $config)
 */
class KisFactory
{

    /**
     * @param string $name
     * @param array $config
     *
     * @return ServiceContainer
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Holt\\KindeeKis\\Apis\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }

}