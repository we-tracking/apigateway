<?php

use App\Routes\Router;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| API HTTP ROUTES
|--------------------------------------------------------------------------
*/

Router::post("/user/authenticate", App\Controller\AuthenticationController::class . "@auth");

Router::group("product", function (Router $router) {
    $router->get("/", App\Controller\ProductsController::class . "@list");
    $router->post("/", App\Controller\ProductsController::class . "@create");
})->prefix("product")->middleware(AuthMiddleware::class);


Router::group("price", function (Router $router) {
    $router->get("/{productId}", App\Controller\ProductHistoryController::class . "@listByProduct");
})->prefix("price")->middleware(AuthMiddleware::class);
