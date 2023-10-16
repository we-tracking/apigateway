<?php

namespace Source\Console\Commands;

use Source\Console\Displayer;

class Seed extends Displayer
{
    public $command = "seed";
    public $description = "roda as seed do banco de dados";
    public $options = [
    ];
    
    public function handler()
    {              
        $this->warning("Starting migrating");
        $pb = $this->progressBar();
        $seeds = $this->getSeeds();
        $pb->start(count($seeds));
        $host = getenv("DB_HOST");
        $user = getenv("DB_USER");
        $pass = getenv("DB_PASS");
        $PDOConfig = "mysql:host=$host;charset=utf8";
        $connection = new \PDO($PDOConfig, $user, $pass);
        foreach($seeds as $seed){
            $connection->prepare($seed)->execute();
        }

        $pb->finish();
    }

    public function getSeeds(): array{
        return [
          "USE wetracking;",
          "INSERT INTO market (name, url, image) values('Extra', 'https://www.clubeextra.com.br', 'https://static.gpa.digital/images/ex/logo-ex.png');"  
        ];
    }
}
