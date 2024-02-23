<?php

namespace App\RPAModules\Domains\Extra;
use App\Curl\Curl;
use App\Contracts\RPAProccess;
use App\Exception\RPAException;

class RPA extends Curl implements RPAProccess 
{   
    public function proccess(string $url): string
    {
        $response = $this->get($url, $this->headers());
        if(!$response->contains('data-testid="product-price-value')){
            throw RPAException::productNotFound(); 
        }
        $price = $response->explode('data-testid="product-price-value" id="product-price">', '<');
        $price = trim(str_replace('R$ ', '', $price));
        if(empty($price)){
            throw  RPAException::priceNotFound();
        }
        return $price;
    }

    private function headers(): array 
    {
        return [
            'Host: www.extra.com.br',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:122.0) Gecko/20100101 Firefox/122.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate, br',
            'Upgrade-Insecure-Requests: 1',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: none',
            'Sec-Fetch-User: ?1',
            'Connection: keep-alive',
        ];
    }
}