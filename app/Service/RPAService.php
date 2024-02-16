<?php

namespace App\Service;

use App\Entity\WebSource;
use App\Contracts\RPAProccess;
use App\RPAModules\Factory\RPAFactory;

class RPAService
{
    public function __construct(
        private RPAFactory $factory
    ) {
    }

    public function getModuleFrom(WebSource $webSource): RPAProccess
    {
        return $this->factory->fromWebSource($webSource);
    }

}

