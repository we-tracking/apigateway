<?php

namespace App\Exception;

class RPAException extends \Exception
{
    public static function productNotFound()
    {
        return new self("Product not found");
    }

    public static function priceNotFound()
    {
        return new self("Price not found");
    }
}
