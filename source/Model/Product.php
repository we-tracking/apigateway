<?php

namespace Source\Model;

use Source\Model\ORM\Column;
use Source\Model\ORM\Entity;
use Source\Model\ORM\Model;

#[Entity("product")]
class Product extends Model{

    #[Column(type: Column::PK, alias: "id")]
    private $id;
    #[Column(alias: "name")]
    private $name;
    #[Column(alias: 'description')]
    private $description;
    #[Column(alias: 'ean')]
    private $ean;
    #[Column(alias: 'user_id')]
    private $user_id;

    public function findByEmail(string $email): object|bool{

        return $this->select()->where("email", $email)->one();
    }
}