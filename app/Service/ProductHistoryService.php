<?php

namespace App\Service;

use App\Entity\Collection\ProductHistoryCollection;
use App\Entity\ProductId;
use App\Entity\WebSourceId;
use App\Model\ProductHistory;

class ProductHistoryService
{
    public function __construct(private ProductHistory $productHistory)
    {

    }

    public function listByProduct(ProductId $productId): array
    {
        return $this->productHistory->getByProductId($productId);
    }

    public function createProductHistory(\App\Entity\ProductHistory $productHistory): \App\Entity\ProductHistoryId
    {
        return $this->productHistory->createProductHistory($productHistory);
    }

    public function getProductHistory(ProductId $productId, WebSourceId $webSourceId): ProductHistoryCollection
    {
        return $this->productHistory->getByProductAndWebSource($productId, $webSourceId);
    }
}
