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
        $collection = unserialize($payload["productWebSourceCollection"]);

        $product = $collection->getProduct();
        foreach ($collection->getWebSources() as $webSource) {
            dd($webSource);

        }
    }
}
