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

    
    public function handler(DBConnect $dbConnection)
    {              
        $this->warning("Starting migrating");
        $pb = $this->progressBar();
        $migrations = $this->getMigrations();
        $pb->start(count($migrations));
        $dbConnection = $dbConnection->getConnection();
        foreach($this->getMigrations() as $migration){
            $dbConnection->raw($migration);
        }

        $pb->finish();

    }

    public function getMigrations(): array{
        return [
            ""
        ];
    }
}
