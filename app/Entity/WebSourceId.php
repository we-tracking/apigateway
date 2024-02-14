<?php

namespace App\Entity;

class WebSourceId
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
