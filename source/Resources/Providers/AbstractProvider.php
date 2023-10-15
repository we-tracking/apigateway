<?php

namespace Source\Resources\Providers;

use Source\Request\Request;

class AbstractProvider extends Provider
{

    public function register()
    {
        $this->app->setAfterFire(
            "Source\\Http\\Request\\Http",
            function ($instance) {
                $request = resolve(Request::class);
                $instance->setUserResolver($request->getUserResolver());
                $instance->setRouteResolver($request->getRouteResolver());
                $instance->fireValidationWithRules();
                $instance->fireValidation();
                return $instance;
            }
        );
    }
}
