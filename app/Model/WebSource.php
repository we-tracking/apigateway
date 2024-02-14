<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\WebSourceId;
use App\ORM\Attributes\Table;

#[Table('web_source')]
class WebSource extends Model
{
    public function getWebSourceById(WebSourceId $webSourceId): \App\Entity\WebSource
    {
        $webSource = $this->find($webSourceId->getId());
        return new \App\Entity\WebSource(
            $webSource->id,
            $webSource->name,
            $webSource->url,
        );
    }

}
