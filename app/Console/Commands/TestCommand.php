<?php

namespace App\Console\Commands;

use App\Curl\Curl;
use App\Console\Command;
use App\Console\Features\ProgressBar;

class TestCommand extends Command
{
    private string $command = "test";
    private string $description = "command built to test the console";

    public function handler(): void
    {

    }
    
    
}
