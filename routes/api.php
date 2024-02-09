<?php

use App\Routes\Router;

/*
|--------------------------------------------------------------------------
| API HTTP ROUTES
|--------------------------------------------------------------------------
*/

Router::post("/user/authenticate", App\Controller\Authentication::class . "@auth");


