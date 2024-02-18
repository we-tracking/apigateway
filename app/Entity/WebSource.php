<?php

namespace App\Entity;

use App\Entity\WebSourceId;
use App\Contracts\ArrayAccessible;

class WebSource implements ArrayAccessible
{
    public function __construct(
        private WebSourceId $webSourceId,
        private string $name,
        private string $url,
    ) {
    }

    public function getWebSourceId(): WebSourceId
    {
        return $this->webSourceId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        return [
            'webSourceId' => $this->webSourceId->getId(),
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
