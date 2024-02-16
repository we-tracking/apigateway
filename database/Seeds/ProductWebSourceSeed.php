<?php

namespace Database\Seeds;

class ProductWebSourceSeed extends \Database\Seed
{
    public function handle(): void 
    {
        $this->create('web_source_products', [
            'web_source_id' => 1,
            'product_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }

}