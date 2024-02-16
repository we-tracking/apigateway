<?php

namespace App\RPAModules\Domains\Extra;
use App\Contracts\RPAProccess;

class RPA implements RPAProccess 
{
    public function process(int $ean): void
    {

        dd($ean);
    }
}