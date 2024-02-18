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
        if($this->product->userHasProduct($product))
        {
            throw new \Exception(trans('messages.errors.productAlreadyExists'));
        }

        return $this->product->createProduct($product);
    }

    public function listUserProducts(UserId $userId): ModelCollection
    {
        return $this->product->findWhere("user_id", "=", $userId->getId());
    }

    public function getAllProducts(): ModelCollection
    {
        return $this->product->all();
    }
}