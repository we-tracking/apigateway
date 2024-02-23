<?php

namespace App\Service;

use App\Model\WebSource;
use App\Entity\ProductId;
use App\Entity\WebSourceId;
use App\Model\WebSourceProducts;
use App\Entity\Collection\ProductWebSourceCollection;

class WebSourceService
{
    public function __construct(
        private WebSource $webSource,
        private WebSourceProducts $webSourceProducts
        )
    {
    }

    public function getWebSourceById(WebSourceId $webSourceId): \App\Entity\WebSource
    {
        return $this->webSource->getWebSourceById($webSourceId);
    }

    public function list(): array
    {
        return $this->webSource->all()->toArray();
    }

    public function getWebSourceFromProductId(ProductId $productId): ?ProductWebSourceCollection
    {
        return $this->webSourceProducts->getWebSourceFromProductId($productId);
    }

    public function createProductWebSource(ProductId $productId, array $webSources)
    {
        $this->webSourceProducts->deleteProductWebSource($productId);
        
        foreach($webSources as $webSource) {
            $webSourceDb = $this->getWebSourceById(new WebSourceId($webSource['id']));
            if($webSourceDb->getUrl() != $this->getDomainFromUrl($webSource['url'])){
                throw new \Exception("Invalid web source url");
            }

            $this->webSourceProducts->createProductWebSource($productId, new WebSourceId($webSource['id']), $webSource['url']);
        }
    }


    public function getDomainFromUrl(string $url): ?string
    {
        return parse_url($url, PHP_URL_HOST);
    }
}

