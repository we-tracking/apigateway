<?php

namespace Source\Controller;

use Source\Model\Market;
use Source\Model\Price;
use Source\Model\Product;
use Source\Request\Request;

class MarketController{
    

    public function __construct(private Market $market){

    }
    public function list(Request $request){
       
        return [
            "data" =>$this->market->all()
        ];
    }

}