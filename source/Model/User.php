<?php

namespace Source\Model;

use Source\Model\ORM\Column;
use Source\Model\ORM\Entity;
use Source\Model\ORM\Model;

#[Entity("user")]
class User extends Model{

    #[Column(type: Column::PK, alias: "id")]
    private $id;
    #[Column(alias: "email")]
    private $email;
    #[Column(alias: 'name')]
    private $name;
    #[Column(alias: 'password')]
    private $password;

    public function findByEmail(string $email): object|bool{

        return $this->select()->where("email", $email)->one();
    }
}