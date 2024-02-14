<?php

namespace App\Console\Commands\Kernel;

use App\Console\Files\Generator;
class GenerateModel extends Generator
{
    public $command = "gen:model";
    public $description = "generate a model class";
    public $options = [
        "<class-name>" => "name of model class"
    ];

    protected function namespace (): string
    {
        return config("app.model.namespace");
    }

    protected function stub(): string
    {
        return resource('stubs/model.stub');
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
        return config("app.model.path");
    }
}

