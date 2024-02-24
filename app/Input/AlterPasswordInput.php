<?php

namespace App\Input;

class AlterPasswordInput extends Input
{
    public function rules(): array
    {
        return [
            'password' => 'required|minLength:8',
            'confirmPassword' => 'required|same:password',
        ];
    }
}

