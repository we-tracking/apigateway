<?php

use App\Routes\Router;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| API HTTP ROUTES
|--------------------------------------------------------------------------
*/

Router::post("/user/authenticate", App\Controller\Authentication::class . "@auth");

Router::group("product", function (Router $router) {
    $router->get("/", App\Controller\Products::class . "@list");
    $router->post("/", App\Controller\Products::class . "@create");
})->prefix("product")->middleware(AuthMiddleware::class);


