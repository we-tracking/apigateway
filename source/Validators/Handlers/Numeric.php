<?php

namespace Source\Validators\Handlers;

class Numeric
{
    public function validate($value): bool
    {
        return is_numeric($value);
    }
}
