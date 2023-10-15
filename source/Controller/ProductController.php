<?php

namespace Source\Controller;

use Source\Csv\Parser;
use Source\Model\Product;
use Source\Request\Request;

class ProductController
{
    
    public function __construct(private Product $product){

    }
    public function import(Request $request){

        $files = $request->getFiles();
        $current = array_shift($files);
        if($current['type'] != 'text/csv'){
            throw new \Exception("Arquivo invalido, formatos aceitos: csv");
        }

        $csv = new Parser($current['tmp_name']);
        foreach($csv->getCurrentStream() as $row){
            $this->product->insert([
                "name" => $row['nome'],
                "description" => $row['descricao'],
                "ean" => $row['ean'],
                "user_id" => $request->user()->id(),
            ])->execute();
        }
        
        return [
            "message" => "arquivo importado com sucesso!"
        ];
    }

    
    public function list(Request $request){

        return [
            "data" => $this->product->select()->where("user_id", $request->user()->id())->execute()
        ];
    }
}