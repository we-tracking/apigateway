<?php

namespace Database\Seeds;

class ProductSeed extends \Database\Seed
{
    public function handle(): void 
    {
        foreach($this->products() as $product) {
            $this->create("products", $product);
        }
    }

    private function products(): array 
    {
        return [
            [
                "user_id" => 1,
                "name" => "Ventilador de Mesa 40cm Mondial Super Turbo VTX-40-8P 8 Pás 3 Velocidades Preto",
                "image_path" => "https://imgs.extra.com.br/50005641/2xg.jpg?imwidth=500",
                "ean" => "7899882309911",
                "status" => "ACTIVE",
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                "user_id" => 1,
                "name" => "Apple iPhone 14 Pro Max 512GB Roxo-profundo",
                "image_path" => "https://imgs.extra.com.br/55054426/1g.jpg?imwidth=500",
                "ean" => "0194253486855",
                "status" => "ACTIVE",
                'created_at' => date("Y-m-d H:i:s")
            ]
        ];
    }

}