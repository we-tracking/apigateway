<?php

namespace App\Service;

use App\Model\ProductHistory;
use App\Entity\ProductId;

class ProductHistoryService
{
    public function __construct(private ProductHistory $productHistory)
    {

    }

    public function listByProduct(ProductId $productId): array
    {
        return $this->productHistory->getByProductId($productId)->toArray();
    }
}
