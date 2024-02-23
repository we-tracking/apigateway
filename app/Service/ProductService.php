<?php

namespace App\Service;

use App\Entity\UserId;
use App\Model\Product;
use App\Entity\ProductId;
use App\Event\Events\RPACollector;
use App\ORM\ModelCollection;
use App\Service\WebSourceService;

class ProductService
{
    public function __construct(
        private Product $product,
        private WebSourceService $webSourceService
        ){

    }

    public function createProduct(\App\Entity\Product $product): ProductId
    {   
        if($productId = $this->product->userHasProduct($product))
        {
            $product->setId($productId);
        }

        return $this->product->createProduct($product);
    }

    public function dispatchToRPA(ProductId $productId): void
    {
        $pws = $this->webSourceService->getWebSourceFromProductId($productId);
        event(new RPACollector($pws));
    }

    public function listUserProducts(UserId $userId): ModelCollection
    {
        return $this->product->findWhere("user_id", "=", $userId->getId());
    }

    public function getAllProducts(): ModelCollection
    {
        return $this->product->all();
    }

    public function commit()
    {
        $this->product->commit();
    }

    public function withRollBack()
    {
        $this->product->disableAutoCommit();
    }
}