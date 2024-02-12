<?php

namespace App\Entity;

use App\Entity\UserId;

class Product
{
    public function __construct(
        private string $name,
        private string $ean,
        private string $imagePath,
        private UserId $userId
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEan(): string
    {
        return $this->ean;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}

