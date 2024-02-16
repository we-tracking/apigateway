<?php

namespace App\RPAModules\Domains\Extra;
use App\Curl\Curl;
use App\Contracts\RPAProccess;

class RPA extends Curl implements RPAProccess 
{
    public function proccess(int $ean): void
    {

        dd($ean);
    }
}