<?php

namespace Source\Controller;

use Source\Csv\Parser;
use Source\Model\Price;
use Source\Model\Product;
use Source\Request\Request;

class PriceController{
    

    public function __construct(private Price $price){

    }
    public function list(Request $request){
        $prices = $this->price->select([
            "market.name" => "market_name",
            "product.name" => "product_name",
            "product.id" => "product_id",
            "price.price" => "price",
            "price.date" => "date",
            "ean" => "ean"
        ])
            ->join("product", "product_id", "=", "product.id")
            ->leftJoin("market", "market_id", "=", "market.id")
            ->where("product.user_id", $request->user()->id())
            
            ->execute();

        return [
            "data" =>$prices
        ];
    }

}