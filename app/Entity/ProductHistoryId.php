<?php

namespace App\Entity;

class ProductHistoryId{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}