<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\ProductId;
use App\ORM\Attributes\Table;
use App\Entity\Product as ProductEntity;

#[Table('products')]
class Product extends Model
{
    public function createProduct(ProductEntity $product)
    {
        $query = $this->insert([
            'name' => ":name",
            "user_id" => ":user_id",
            'ean' => ":ean",
            'image_path' => ":image_path",
            'created_at' => "NOW()"
        ]);

        $result = $query->addParams([
            ':name' => $product->getName(),
            ':user_id' => $product->getUserId()->getId(),
            ':ean' => $product->getEan(),
            ':image_path' => $product->getImagePath()
        ])->execute();

        return new ProductId($result->lastId());
    }
}

