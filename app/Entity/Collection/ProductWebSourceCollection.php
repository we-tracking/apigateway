<?php

namespace App\Entity\Collection;

use App\Entity\Product;
use App\Entity\WebSource;

class ProductWebSourceCollection
{
    public function __construct(
        private Product $product,
        private array $webSources
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /** @return array<WebSource> */
    public function getWebSources(): array
    {
        return $this->webSources;
    }
}

