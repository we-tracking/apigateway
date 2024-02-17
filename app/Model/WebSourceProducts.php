<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\UserId;
use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\WebSource;
use App\Entity\WebSourceId;
use App\ORM\Attributes\Table;
use App\ORM\Connection\Group\ConnectionGroup;
use App\ORM\Connection\Group\DefaultConnection;
use App\Entity\Collection\ProductWebSourceCollection;

#[Table('web_source_products')]
class WebSourceProducts extends Model
{

    public function getWebSourceFromProductId(ProductId $productId): ?ProductWebSourceCollection
    {
        $result = $this->select([
            "web_source.id as web_source_id",
            "web_source.name as web_source_name",
            "web_source.domain as web_source_domain",
            "web_source.logo_path as web_source_logo_path",
            "products.id as product_id",
            "products.ean as product_ean",
            "products.image_path as product_image_path",
            "products.name as product_name",
            "products.user_id as product_user_id",

        ])
            ->join("web_source", "web_source.id = web_source_products.web_source_id")
            ->join("products", "products.id = web_source_products.product_id")
            ->where("web_source_products.product_id","=", ":productId")
            ->addParam(":productId", $productId->getId())
            ->execute()->fetchAll();

        if(empty($result)){
            return null;
        }

        $product = new Product(
            $productId,
            $result[0]['product_name'],
            $result[0]['product_ean'],
            $result[0]['product_image_path'],
            new UserId($result[0]['product_user_id'])
        );

        $webSources = array_map(function($webSource){
            return new WebSource(
                new WebSourceId($webSource['web_source_id']),
                $webSource['web_source_name'],
                $webSource['web_source_domain'],
            );
        }, $result);

        return new ProductWebSourceCollection($product, $webSources);
    }

}
