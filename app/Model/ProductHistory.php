<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\ProductId;
use App\ORM\ModelCollection;
use App\ORM\Attributes\Table;
use App\Entity\ProductHistoryId;

#[Table('product_history')]
class ProductHistory extends Model
{
    public function getByProductId(ProductId $productId): ModelCollection
    {
        return $this->findWhere("product_id", "=", $productId->getId());
    }

    public function createProductHistory(\App\Entity\ProductHistory $productId): ProductHistoryId
    {
        $query = $this->insert([
            'web_source_id' => ":web_source_id",
            "product_id" => ":product_id",
            'price' => ":price",
            'created_at' => "NOW()"
        ]);

        $result = $query->addParams([
            ':web_source_id' => $productId->getWebSourceId()->getId(),
            ':product_id' => $productId->getProductId()->getId(),
            ':price' => $productId->getPrice()
        ])->execute();

        return new ProductHistoryId($result->lastId());
    }

}
