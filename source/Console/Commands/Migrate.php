<?php

namespace Source\Console\Commands;

use Source\Console\Displayer;
use Source\Connection\DBConnect;

class Migrate extends Displayer
{
    public $command = "migrate";
    public $description = "roda as mirations do banco de dados";
    public $options = [
    ];
    
    public function handler()
    {              
        $this->warning("Starting migrating");
        $pb = $this->progressBar();
        $migrations = $this->getMigrations();
        $pb->start(count($migrations));
        $host = getenv("DB_HOST");
        $user = getenv("DB_USER");
        $pass = getenv("DB_PASS");
        $dbName = getenv("DB_NAME");
        $PDOConfig = "mysql:host=$host;dbname=$dbName;charset=utf8";
        $connection = new \PDO($PDOConfig, $user, $pass);
        foreach($this->getMigrations() as $migration){
            $connection->prepare($migration)->execute();
        }

        $pb->finish();

    }

    public function getMigrations(): array{
        return [
           "CREATE DATABASE wetracking;",
           "CREATE TABLE `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(100) DEFAULT NULL,
            `name` varchar(100) DEFAULT NULL,
            `password` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;",
          "CREATE TABLE `market` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) DEFAULT NULL,
            `url` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;",
          "CREATE TABLE `product` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) DEFAULT NULL,
            `description` varchar(100) DEFAULT NULL,
            `ean` varchar(100) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
          ",
          "CREATE TABLE `price` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `price` varchar(45) DEFAULT NULL,
            `product_id` int(11) DEFAULT NULL,
            `date` datetime DEFAULT NULL,
            `market_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
          "
        ];
    }
}
