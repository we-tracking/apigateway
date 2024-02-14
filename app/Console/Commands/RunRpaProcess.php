<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Console\Features\ProgressBar;

class RunRpaProcess extends Command
{
    private string $command = "run:rpa-process";
    private string $description = "put into queue Products in RPA process";

    public function handler(ProgressBar $pb): void
    {
        $this->quote("set products to queue!");
    }
}

