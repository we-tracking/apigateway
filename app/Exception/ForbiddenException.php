<?php

namespace App\Exception;

class ForbiddenException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 403);
    }
}
