<?php

namespace App\Event\Listeners;

use App\Event\Listener;
use App\Entity\WebSource;
use App\Service\RPAService;
use App\Entity\ProductHistory;
use App\Service\ProductHistoryService;
use App\Entity\Collection\ProductWebSourceCollection;
use App\Exception\RPAException;

class ProductWebSorceHandler implements Listener
{
    public function __construct(
        private RPAService $rpaService,
        private ProductHistoryService $productHistoryService
    ){
    }
    
    public function name(): string
    {
        return "ProductWebSourceHandler";
    }

    public function handle(array $payload): void
    {   
        /** @var ProductWebSourceCollection */
        $collection = unserialize($payload["productWebSourceCollection"]);

        $product = $collection->getProduct();
        /** @var WebSource $websource */
        foreach ($collection->getWebSources() as $webSource) {
            $rpa = $this->rpaService->getModuleFrom($webSource);

            try{
                $this->productHistoryService->createProductHistory(
                    new ProductHistory(
                         $webSource->getWebSourceId(),
                         $product->getId(),
                         $rpa->proccess($product->getEan())
                    )
                 );
            }catch(RPAException $error){
                dd($error->getMessage());
            }

        }
    }
}
