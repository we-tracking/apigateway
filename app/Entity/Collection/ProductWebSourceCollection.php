<?php

namespace App\Entity\Collection;

use App\Entity\Product;
use App\Entity\WebSource;
use App\Entity\Collection\Collection;

class ProductWebSourceCollection extends Collection
{
    public function __construct(
         Product $product,
         array $webSources
    ) {
        parent::__construct([
            "product" => $product,
            "webSources" => $webSources
        ]); 
    }

    public function getProduct(): Product
    {
        return $this->items['product'];
    }

    /** @return array<WebSource> */
    public function getWebSources(): array
    {
        return $this->items['webSources'];
    }
}

