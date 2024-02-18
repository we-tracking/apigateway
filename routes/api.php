<?php

use App\Routes\Router;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| API HTTP ROUTES
|--------------------------------------------------------------------------
*/

Router::post("/user/authenticate", App\Controller\AuthenticationController::class . "@auth");
Router::post("/user/create", App\Controller\UserController::class . "@create");

Router::group("product", function (Router $router) {
    $router->get("/", App\Controller\ProductsController::class . "@list");
    $router->post("/", App\Controller\ProductsController::class . "@create");
    $router->get("/history/{productId}", App\Controller\ProductHistoryController::class . "@listByProduct");
})->prefix("product")->middleware(AuthMiddleware::class);

Router::group("web-source", function (Router $router) {
    $router->get("/", App\Controller\WebSourceController::class . "@list");
    $router->get("/product/{productId}", App\Controller\WebSourceController::class . "@listProductWebSource");
})->prefix("web-source")->middleware(AuthMiddleware::class);