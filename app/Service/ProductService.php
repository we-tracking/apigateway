<?php

namespace App\Service;

use App\Entity\UserId;
use App\Model\Product;
use App\Entity\ProductId;
use App\ORM\ModelCollection;

class ProductService
{
    public function __construct(private Product $product){

    }

    public function createProduct(\App\Entity\Product $product): ProductId
    {
        return $this->product->createProduct($product);
    }

    public function listUserProducts(UserId $userId): ModelCollection
    {
        return $this->product->findWhere("user_id", "=", $userId->getId());
    }
}