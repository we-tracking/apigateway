<?php

namespace App\Entity;

class ProductId
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}

