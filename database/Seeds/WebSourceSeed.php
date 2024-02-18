<?php

namespace Database\Seeds;

class WebSourceSeed extends \Database\Seed
{
    public function handle(): void 
    {
        foreach($this->webSources() as $webSource)
        {
            $this->create('web_source', $webSource);
        }
    }

    public function webSources(): array 
    {
        return [
            [
                'name' => 'Extra',
                'domain' => 'www.extra.com.br',
                'logo_path' => 'https://www.extra-imagens.com.br/App_Themes/Extra/img/header/r/logo.svg',
                'status' => 'ACTIVE',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Casas Bahia',
                'domain' => 'www.casasbahia.com.br',
                'logo_path' => 'https://www.casasbahia-imagens.com.br/App_Themes/CasasBahia/img/header/r/logo.svg',
                'status' => 'ACTIVE',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Ponto Frio',
                'domain' => 'www.pontofrio.com.br',
                'logo_path' => 'https://www.pontofrio-imagens.com.br/App_Themes/PontoFrio/img/header/r/logo.svg',
                'status' => 'ACTIVE',
                'created_at' => date("Y-m-d H:i:s")
            ]

        ];
    }

}