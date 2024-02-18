<?php

namespace App\Validation\Handlers;

use Validators\Contracts\ValidatorHandler;

class Email implements ValidatorHandler
{
    public function handle($value): bool
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value ?? "");
    }
}
