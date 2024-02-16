<?php

namespace App\Event\Listeners;

use App\Event\Listener;
use App\Entity\WebSource;
use App\Service\RPAService;

class ProductWebSorceHandler implements Listener
{
    public function __construct(
        private RPAService $rpaService
    ){
    }
    
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
            $rpa = $this->rpaService->getModuleFrom($webSource);
            dd($rpa);
        }
    }
}
