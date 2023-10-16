<?php

namespace Source\Console\Commands;

use Source\Model\Market;
use Source\Model\Product;
use Source\Console\Displayer;
use Source\Api\Rpa\Integration;
use Source\Connection\DBConnect;
use Source\Model\Price;

class Collect extends Displayer
{
    public $command = "collect-price";
    public $description = "coleta os preços dos produtos";
    public $options = [
    ];

    public function handler(Integration $rpa, Product $product, Market $market, Price $price)
    {  
        $products = $product->all();
        $markets = $market->all();

        foreach($products as $product){
            foreach($markets as $market){
               $response = $rpa->getPrices(
                    $product->ean,
                    $market->url
                );

                $response = $response->json();
                if(!$response->status){
                    continue;
                }

                $price->insert([
                  "price" =>  $response->data->FinalPrice,
                  "product_id" => $product->id,
                  "market_id" => $market->id,
                  "date" => date("Y-m-d H:i:s")

                ])->execute();

            }
        }
    }

}
