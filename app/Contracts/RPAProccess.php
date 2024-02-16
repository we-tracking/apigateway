<?php

namespace App\Contracts;

interface RPAProccess
{
    public function proccess(int $ean): string;
}
