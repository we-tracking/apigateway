<?php

namespace Database\Seeds;

class WebSourceSeed extends \Database\Seed
{

    public function handle(): void 
    {
        $this->create('web_source', [
            'name' => 'Extra',
            'domain' => 'www.extra.com.br',
            'logo_path' => 'https://www.extra-imagens.com.br/App_Themes/Extra/img/header/r/logo.svg',
            'status' => 'ACTIVE',
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }

}