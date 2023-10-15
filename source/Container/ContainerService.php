<?php

namespace Source\Container;

use Source\Helpers\ClassLoader;
use Source\Resources\Providers;
use Source\Resources\Providers\Provider;

class ContainerService
{

    private ClassLoader $loader;

    private static $init = false;

    public function __construct()
    {
        $this->loader = new ClassLoader(Providers::class, true);
        $this->loader->unload([Providers\Provider::class]);
    }

    public static function isInitialized(): bool
    {
        return self::$init;
    }

    public function build()
    {
        if (self::$init) {
            return;
        }

        foreach ($this->loader->load() as $provider) {
            if (($instance = resolve($provider)) instanceof Provider) {
                if (method_exists($instance, "register")) {
                    resolve(
                        $instance->{"register"}(...)
                    );
                }
            }
        }

        self::$init = true;
    }
}
