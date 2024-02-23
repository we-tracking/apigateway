<?php

namespace App\Contracts;

interface RPAProccess
{
    public function proccess(string $url): string;
}
