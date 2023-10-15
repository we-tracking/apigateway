<?php

namespace Source\Console\Commands;

use Source\Console\Displayer;
use Source\Connection\DBConnect;
use Source\Model\Product;

class Collect extends Displayer
{
    public $command = "collect-price";
    public $description = "coleta os preços dos produtos";
    public $options = [
    ];

    public function handler(Product $product)
    {  
        $products = $product->all();

        foreach($products as $product){

        }
    }

}
