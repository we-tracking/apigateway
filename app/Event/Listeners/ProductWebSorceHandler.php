<?php

namespace App\Event\Listeners;

use App\Event\Listener;
use App\Console\Command;
use App\Entity\WebSource;
use App\Service\RPAService;
use App\Entity\ProductHistory;
use App\Exception\RPAException;
use App\Service\ProductHistoryService;
use App\Entity\Collection\ProductWebSourceCollection;

class ProductWebSorceHandler extends Command implements Listener
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
        $this->info("Processing product: {$product->getName()}");
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

                 $this->success($webSource->getName());
            }catch(RPAException $error){
                $this->error($webSource->getName());
            }

        }
    }
}
