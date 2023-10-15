<?php

namespace Source\Model;

use Source\Model\ORM\Column;
use Source\Model\ORM\Entity;
use Source\Model\ORM\Model;

#[Entity("price")]
class Price extends Model{

    #[Column(type: Column::PK, alias: "id")]
    private $id;
    #[Column(alias: "price")]
    private $price;
    #[Column(alias: 'product_id')]
    private $product_id;
    #[Column(alias: 'date')]
    private $date;
    #[Column(alias: 'market_id')]
    private $market_id;
}