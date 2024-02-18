<?php

namespace App\RPAModules\Factory;

class Registration
{
    public static function register(): array 
    {
        return [
            "www.extra.com.br" => \App\RPAModules\Domains\Extra\RPA::class,
            "www.casasbahia.com.br" => \App\RPAModules\Domains\CasasBahia\RPA::class,
        ];
    }
}