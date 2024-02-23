<?php

namespace App\Entity;

use App\Entity\UserId;
use App\Contracts\ArrayAccessible;

class Product implements ArrayAccessible
{
    public function __construct(
        private ProductId $id,
        private string $name,
        private string $ean,
        private string $imagePath,
        private UserId $userId
    ) {
    }

    public function getId(): ProductId
    {
        return $this->id;
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

    public function setId(ProductId $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getId(),
            'name' => $this->name,
            'ean' => $this->ean,
            'imagePath' => $this->imagePath,
            'userId' => $this->userId->getId()
        ];
    }
}

