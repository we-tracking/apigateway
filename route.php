<?php

ini_set('display_errors', 0);

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/boot/Application.php";

/*
|--------------------------------------------------------------------------
| ROTAS DA API \ VERBO HTTP
|--------------------------------------------------------------------------
| Aqui ficam as rotas da aplicacao, que serao utilizadas para  a chamada dos 
| servicos.
|
*/

use Source\Router\Router;
use Source\Http\Middleware;
use Source\Request\Request;
use Source\Http\Middleware\Auth;

header('Content-Type: application/Json');

$router = new Router(getenv("BASE_PREFIX"));
$router->namespace("Source\Controller");

/** Usuario */
$router->post("/user/authentication", "User:auth");
$router->post("/user/register", "User:register");
$router->post("/product/import", "ProductController:import", null, Auth::class);
$router->get("/price/list", "PriceController:list", null, Auth::class);
$router->get("/product/list", "ProductController:list", null, Auth::class);
$router->get("/product/id/{id}", "ProductController:byId", null, Auth::class);
$router->get("/product/id", "ProductController:list", null, Auth::class);
$router->get("/market/list", "MarketController:list", null, Auth::class);

/** Erros **/
$router->get("/404", "ErrorController:notFound");
$router->get("/403", "ErrorController:forbidden");
$router->get("/501", "ErrorController:notImplemented");

/** TESTES */
$router->post("/container", "TestController:container");

$router->dispatch(container(Request::class));

/*** Erro de redirect */
if (!is_null($router->error())) {
    $router->redirect("/erro/{$router->error()}");
}
