<?php

namespace App\Input;

class UserCreationInput extends Input
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|minLength:8',
            'confirmPassword' => 'required|same:password',
        ];
    }
}

