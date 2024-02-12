<?php

namespace App\Console\Commands\Kernel;

use App\Console\Files\Generator;

class GenerateInput extends Generator
{
    public $command = "gen:input";
    public $description = "generate a input class";
    public $options = [
        "<class-name>" => "name of input class"
    ];

    protected function namespace (): string
    {
        return config("request.input.namespace");
    }

    protected function stub(): string
    {
        return resource('stubs/input.stub');
    }

    protected function name(): string
    {
        if ($name = $this->argument(2)) {
            return $name;
        }
        throw new \Exception("<class-name> is required for this command");
    }

    protected function folder(): string
    {
        return config("request.input.path");
    }
}
