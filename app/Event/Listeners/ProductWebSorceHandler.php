<?php

namespace App\Event\Listeners;

use App\Event\Listener;
use App\Entity\WebSource;

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
        /** @var WebSource $websource */
        foreach ($collection->getWebSources() as $webSource) {
            dd($webSource);
        }
    }
}
