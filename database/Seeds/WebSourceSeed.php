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
            ],
            [
                'name' => 'Carrefour',
                'domain' => 'www.carrefour.com.br',
                'logo_path' => 'https://carrefourbr.vtexassets.com/assets/vtex.file-manager-graphql/images/c38d7260-359d-4a84-8a56-c92a85a55b07___0fe5a16842979f7664f02f8612015eca.png',
                'status' => 'ACTIVE',
                'created_at' => date("Y-m-d H:i:s")
            ]

        ];
    }

}