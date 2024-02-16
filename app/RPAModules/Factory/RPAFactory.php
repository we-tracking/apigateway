<?php

namespace App\RPAModules\Factory;

use App\Container\ContainerInterface;
use App\Entity\WebSource;
use App\Contracts\RPAProccess;
use App\RPAModules\Factory\Registration;

class RPAFactory
{
    public function __construct(private ContainerInterface $container){
    }

    public function fromWebSource(WebSource $webSource): RPAProccess
    {
        $registration = $this->findRegistration($webSource->getUrl());
        return $this->container->make($registration);
    }

    private function findRegistration(string $domain): ?string
    {
        $registration = $this->getRegistration();
        $registration = $registration[$domain] ?? null;

        if(!is_string($registration)) {
            throw new \Exception("Class {$registration} not found");
        }

        if(!$this->implementsRpa($registration)) {
            throw new \Exception("Class {$registration} not implement RPAProccess");
        }

        return $registration;
    }

    private function implementsRpa(string $class): bool
    {
        $implementation = (new \ReflectionClass($class))->getInterfaceNames();
        return in_array(RPAProccess::class, $implementation);
    }

    private function getRegistration(): array
    {
        return Registration::register();
    }
}

