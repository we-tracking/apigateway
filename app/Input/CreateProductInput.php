<?php

namespace App\Input;

class CreateProductInput extends Input
{
    public function rules(): array
    {
        return [
            "name" => "required|string|maxLength:255|minLength:3",
            "ean" => "required",
            "imagePath" => "required",
        ];
    }
}

