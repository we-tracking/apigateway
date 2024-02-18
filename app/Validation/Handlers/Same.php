<?php

namespace App\Validation\Handlers;

use App\Container\Container;
use App\Http\Request\RequestInterface;
use Validators\Contracts\ValidatorHandler;

class Same implements ValidatorHandler
{
    public function __construct(private mixed $input){

    }

    public function handle(mixed $same): bool
    {   
        $input = $this->getRequest()->inputs($this->input);
        return $input === $same;
    }

    public function getRequest(): RequestInterface
    {
        return Container::getInstance()->make(RequestInterface::class);
    }
}