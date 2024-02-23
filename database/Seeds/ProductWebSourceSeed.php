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
                "web_source_url" => "https://www.extra.com.br/ventilador-de-mesa-40cm-mondial-super-turbo-vtx-40-8p-8-pas-3-velocidades-preto/p/50005641?utm_source=gp_branding&utm_medium=cpc&utm_campaign=gg_brd_inst_ex_exata",
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 2,
                'product_id' => 1,
                "web_source_url" => "https://www.casasbahia.com.br/ventilador-de-mesa-40cm-mondial-super-turbo-vtx-40-8p-8-pas-3-velocidades-preto/p/50005641?utm_source=gp_branding&utm_medium=cpc&utm_campaign=gg_brd_inst_cb_exata",
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 1,
                'product_id' => 2,
                "web_source_url" => "https://www.extra.com.br/apple-iphone-14-pro-max-512gb-roxo-profundo/p/55054426?utm_source=gp_branding&utm_medium=cpc&utm_campaign=gg_brd_inst_ex_exata",
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 2,
                'product_id' => 2,
                "web_source_url" => "https://www.casasbahia.com.br/apple-iphone-14-pro-max-512gb-roxo-profundo/p/55054426?utm_source=gp_branding&utm_medium=cpc&utm_campaign=gg_brd_inst_cb_exata",
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'web_source_id' => 3,
                'product_id' => 2,
                "web_source_url" => "https://www.pontofrio.com.br/apple-iphone-14-pro-max-512gb-roxo-profundo/p/55054426?utm_source=gp_branding&utm_medium=cpc&utm_campaign=gg_brd_inst_ponto_exata",
                'created_at' => date("Y-m-d H:i:s")
            ]
        ];
    }

}