<?php

namespace App\Entity;

use App\Entity\WebSourceId;

class ProductHistory{

    public function __construct(
        private WebSourceId $webSourceId,
        private ProductId $productId,
        private string $price
    ){
    }

    public function getWebSourceId(): WebSourceId
    {
        return $this->webSourceId;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

}