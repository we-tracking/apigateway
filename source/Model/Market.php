<?php

namespace Source\Model;

use Source\Model\ORM\Column;
use Source\Model\ORM\Entity;
use Source\Model\ORM\Model;

#[Entity("market")]
class Market extends Model{

    #[Column(type: Column::PK, alias: "id")]
    private $id;
    #[Column(alias: "name")]
    private $name;
    #[Column(alias: 'url')]
    private $url;
    #[Column(alias: 'image')]
    private $image;
}