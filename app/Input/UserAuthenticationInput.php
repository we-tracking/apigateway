<?php

namespace App\Input;

class UserAuthenticationInput extends Input
{
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required|string"
        ];
    }
}

