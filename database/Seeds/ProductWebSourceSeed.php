<?php

namespace Database\Seeds;

class ProductWebSourceSeed extends \Database\Seed
{
    public function handle(): void 
    {
        foreach($this->webSourceProducts() as $webSourceProduct) {
            $this->create('web_source_products', $webSourceProduct);
        }
    }

    public function webSourceProducts(): array 
    {
        return [
            [
                'web_source_id' => 1,
                'product_id' => 1,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 2,
                'product_id' => 1,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 1,
                'product_id' => 2,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 2,
                'product_id' => 2,
                'created_at' => date("Y-m-d H:i:s")
            ]
        ];
    }

}