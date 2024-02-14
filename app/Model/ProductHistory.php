<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\ProductId;
use App\ORM\ModelCollection;
use App\ORM\Attributes\Table;

#[Table('product_history')]
class ProductHistory extends Model
{
    public function getByProductId(ProductId $productId): ModelCollection
    {
        return $this->findWhere("product_id", "=", $productId->getId());
    }

}
