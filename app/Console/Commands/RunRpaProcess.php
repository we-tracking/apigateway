<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Entity\ProductId;
use App\Service\RPAService;
use App\Service\ProductService;
use App\Service\WebSourceService;
use App\Event\Events\RPACollector;
use App\Console\Features\ProgressBar;

class RunRpaProcess extends Command
{
    private string $command = "run:rpa-process";
    private string $description = "put into queue Products in RPA process";

    public function __construct(
        private ProductService $productService,
        private WebSourceService $webSourceService
    ) {
    }

    public function handler(
        ProgressBar $progressBar
    ): void {
        $this->quote("set products to queue!");
        $products = $this->productService->getAllProducts();
        $progressBar->start($products->count());
        foreach ($products->getModels() as $product) {
            $pws = $this->webSourceService->getWebSourceFromProductId(new ProductId($product->id));
            if ($pws == null) {
                $progressBar->increment();
                continue;
            }
            event(new RPACollector($pws));
        }

        $progressBar->finish();


    }
}

