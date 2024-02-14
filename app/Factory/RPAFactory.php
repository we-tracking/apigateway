<?php

namespace App\Factory;

use App\Entity\WebSource;
use App\Contracts\RPAProccess;

class RPAFactory
{
    public function fromWebSource(WebSource $webSource): RPAProccess
    {
        $pascalCase = pascalCase($webSource->getName());
        $className = $this->getNamespace() . $pascalCase;
        if (class_exists($className)) {
            $implementation = (new \ReflectionClass($className))->getInterfaceNames();
            if(in_array(RPAProccess::class, $implementation)) {
                return new $className();
            }
            throw new \Exception("Class {$className} not implement RPAProccess");
        }

        throw new \Exception("Class {$className} not found");
    }

    private function getNamespace(): string
    {
        return 'App\\RPA\\';
    }
}

