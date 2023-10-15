<?php

namespace Source\Contracts;

interface ExceptionHandlerInterface
{
    public function render(\Throwable $e);
}