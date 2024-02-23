<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\UserId;
use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\WebSource;
use App\Entity\WebSourceId;
use App\ORM\Attributes\Table;
use App\Entity\Collection\ProductWebSourceCollection;

#[Table('web_source_products')]
class WebSourceProducts extends Model
{
    public function getWebSourceFromProductId(ProductId $productId): ?ProductWebSourceCollection
    {
        $result = $this->queryBuilder()->select([
            "products.id as product_id",
            "products.ean as product_ean",
            "products.image_path as product_image_path",
            "products.name as product_name",
            "products.user_id as product_user_id",

        ])->from('products')
            ->where("products.id","=", ":productId")
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

        return new ProductWebSourceCollection($product, $this->getProductWebSource($productId));
    }

    public function getProductWebSource(ProductId $productId): array 
    {
        $result = $this->select([
            "web_source.id as web_source_id",
            "web_source.name as web_source_name",
            "web_source.domain as web_source_domain",
            "web_source.logo_path as web_source_logo_path",
            "web_source_products.web_source_url as web_source_url"

        ])
            ->join("web_source", "web_source.id = web_source_products.web_source_id")
            ->where("web_source_products.product_id","=", ":productId")
            ->addParam(":productId", $productId->getId())
            ->execute()->fetchAll();

            $webSources = array_map(function($webSource){
                return new WebSource(
                    new WebSourceId($webSource['web_source_id']),
                    $webSource['web_source_name'],
                    $webSource['web_source_url'],
                );
            }, $result);

            return $webSources;
    }

    public function createProductWebSource(ProductId $productId, WebSourceId $webSourceId)
    {
        $this->insert([
            "product_id" => ":productId",
            "web_source_id" => ":webSourceId",
            "created_at" => "now()",
        ])->addParams([
            ":productId" => $productId->getId(),
            ":webSourceId" => $webSourceId->getId()
        ])->execute();
    }

}
