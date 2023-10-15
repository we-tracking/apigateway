<?php

use Source\Request\Request;
use Source\Api\Webcred\Access;
use Source\Container\Container;
use Source\Api\ApiGateway\Services\Token;

/*
|--------------------------------------------------------------------------
| Boot da aplicacao
|--------------------------------------------------------------------------
| Aqui fica as configuracoes de inicializacao da aplicacao
|
*/

$container = Container::getInstance();
$container->bind(
    Container::class,
    fn () => Container::getInstance()
);

$container->bind(
    Request::class,
    fn () => Request::creacteFromGlobals()
);

$container->bind(
    Source\Console\Console::class,
    fn () => new Source\Console\Console(
        Source\Console\Bags\OptionBag::createFromArgs()
    )
);

$container->bind(
    Source\Contracts\ExceptionHandlerInterface::class,
    fn () => new Source\Exception\Handler
);


return $container;
