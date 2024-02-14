<?php

namespace App\Event\Listeners;

use App\Event\Listener;

class ProductWebSorceHandler implements Listener
{
    public function name(): string
    {
        return "ProductWebSourceHandler";
    }

    public function handle(array $payload): void
    {
        dd($payload);
    }
}
