<?php

namespace App\Entity;

use App\Entity\WebSourceId;

class WebSource
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
}
