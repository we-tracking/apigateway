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
    public function getByProductId(ProductId $productId, ?int $limit = null, ?int $page = null): array
    {   
        $query = $this->select([
            "product_id" => "productId",
            "web_source_id" => "webSourceId",
            "price" => "price",
            "MAX(product_history.created_at)" => "lastCheck",
            "web_source.name" => "webSourceName",
            "web_source.logo_path" => "webSourceLogo",
            "web_source.domain" => "domain"
        ])
            ->join('web_source', 'web_source_id = web_source.id')
            ->where("product_id", "=", ':productId')
            ->addParams([":productId" => $productId->getId()])
            ->groupBy("web_source_id");
            
            if($limit && $page){
                $count = $this->countTotalProductHistory($productId);
                $query->limit($limit)->offset((int)ceil($count/$limit * ($page - 1)));
                $query->fields([
                    "page" => $page,
                    "totalPages" => $count/$limit,
                    "results" => $count
                ]);
            }

        return $query->execute()->fetchAll();
    }

    public function countTotalProductHistory(ProductId $productId): int
    {
        $query = $this->select('count(*) as total')->where("product_id", "=", ':productId');
        $result = $query->addParam(":productId", $productId->getId())->execute()->fetchAll();
        return $result[0]['total'];
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
