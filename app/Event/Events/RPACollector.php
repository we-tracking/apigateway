<?php

namespace App\Event\Events;

use App\Event\EventHandler;
use App\Entity\Collection\ProductWebSourceCollection;

class RPACollector extends EventHandler
{

    public function __construct(
        private ProductWebSourceCollection $productWebSourceCollection
    ) {
    }
    
    public function channels(): array
    {
        return [
            "ProductWebSourceHandler"
        ];
    }

    public function payload(): array
    {   
        return [
            "productWebSourceCollection" => serialize($this->productWebSourceCollection)
        ];
    }

}