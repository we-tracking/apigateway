<?php

namespace Database\Seeds;

class ProductSeed extends \Database\Seed
{
    public function handle(): void 
    {
        $this->create("products", [
            "user_id" => 1,
            "name" => "Ventilador de Mesa 40cm Mondial Super Turbo VTX-40-8P 8 Pás 3 Velocidades Preto",
            "image_path" => "https://imgs.extra.com.br/50005641/2xg.jpg?imwidth=500",
            "ean" => "50005641",
            "status" => "ACTIVE",
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }

}