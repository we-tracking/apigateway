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
            ],
            [
                "web_source_id" => 4,
                "product_id" => 2,
                "web_source_url" => "https://www.carrefour.com.br/iphone-14-pro-max-roxo-512gb-mp933071325/p?utm_medium=sem&utm_source=google_pmax_3p&utm_campaign=3p_performancemax_Eletro_Smartphone&gad_source=1&gclid=Cj0KCQiAoeGuBhCBARIsAGfKY7zOa9mpB8OhBfImfPRfYb03iw8Vh9X5TIeWHrou5FekDQq8lQsm_OkaAizFEALw_wcB",
                'created_at' => date("Y-m-d H:i:s")
            ]
        ];
    }

}