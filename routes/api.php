<?php

use App\Routes\Router;

/*
|--------------------------------------------------------------------------
| API HTTP ROUTES
|--------------------------------------------------------------------------
*/

Router::post("/user/authenticate", App\Controller\Authentication::class . "@auth");

Router::group("products", function (Router $router) {
    $router->get("/", App\Controller\Products::class . "@list");
})->prefix("products");


