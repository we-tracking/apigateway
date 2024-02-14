<?php

namespace App\Service;

use App\Entity\WebSource;
use App\Factory\RPAFactory;
use App\Contracts\RPAProccess;

class RPAService
{
    public function __construct(
        private RPAFactory $factory
    ) {
    }

    private function getInstanceFromWebSource(WebSource $webSource): RPAProccess
    {
        return $this->factory->fromWebSource($webSource);
    }

}

