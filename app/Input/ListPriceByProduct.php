<?php

namespace App\Input;

class ListPriceByProduct extends Input
{
    public function rules(): array
    {
        return [
            "productId" => "required|numeric"
        ];
    }
}

