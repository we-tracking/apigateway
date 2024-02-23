<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\UserId;
use App\Entity\ProductId;
use App\ORM\Attributes\Table;
use App\Entity\Product as ProductEntity;

#[Table('products')]
class Product extends Model
{

    public function createProduct(ProductEntity $product): ProductId
    {
        if($product->getId()->getId() === null){
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

        $query = $this->update([
            'name' => ":name",
            'ean' => ":ean",
            'image_path' => ":image_path",
            'updated_at' => "NOW()"
        ])->where('id', '=', ':id');
        
    
        $result = $query->addParams([
            ':name' => $product->getName(),
            ':ean' => $product->getEan(),
            ':image_path' => $product->getImagePath(),
            ":id" => $product->getId()->getId(),
            ])->execute();
   
        return $product->getId();
    }

    public function userHasProduct(ProductEntity $product): false|ProductId
    {
        $query = $this->select()
        ->where('user_id', '=', ':userId')
        ->where('ean', '=', ':ean')
        ->addParams([
            ':userId' => $product->getUserId()->getId(),
            ':ean' => $product->getEan()
        ]);

        $result = $query->execute()->fetchAll();
        if(count($result) > 0){
            return new ProductId($result[0]['id']);
        };

        return false;
    }
}

