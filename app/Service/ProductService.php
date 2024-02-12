<?php

namespace App\Service;

use App\Model\Product;
use App\Entity\ProductId;

class ProductService
{
    public function __construct(private Product $product){

    }

    public function createProduct(\App\Entity\Product $product): ProductId
    {
        return $this->product->createProduct($product);
    }
}