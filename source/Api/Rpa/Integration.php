<?php

namespace Source\Api\Rpa;

use Source\Curl\Curl;
use Source\Curl\CurlResponse;

class Integration extends Curl{

    private ?string $url;
    public function __construct(){
        $this->url = getenv('RPA_URL');
        $this->setPostFormatter(fn($post) => json_encode($post));
    }
    public function getPrices(
        ?string $ean,
        ?string $url
    ): CurlResponse {
        return $this->post($this->endpoint('/api/search'), [
            "ProductsIdentifiers" => $ean,
            "Url" => $url
        ]);
    }

    private function endpoint(string $endpoint){
        return $this->url . $endpoint;
    }

}