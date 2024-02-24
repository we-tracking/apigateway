<?php

return [
    'validation' => [
        'required' => 'O campo :field é obrigatório',
        'string' => 'O campo :field deve ser uma string',
        'minLength' => 'O campo :field deve ter no mínimo :min caracteres',
        'email' => 'O campo :field deve ser um email válido',
        'same' => 'O campo :field deve ser igual ao campo :input',
    ],

    'errors' => [
        'userNotFound' => 'Usuário não encontrado',
        'invalidPassword' => 'Email ou senha inválidos!',
        'userAlreadyExists" => "Usuário já cadastrado!',
        'productNotFound' => 'Produto não encontrado',
        'productAlreadyExists' => 'usuario ja possui um produto com ean fornecido cadastrado!',
        'webSourceNotFound' => 'Web não encontrada',
    ],

    'success' => [
        'authenticated' => 'Usuario autenticado com sucesso',
        'productPriceList' => 'Lista de preços por produto gerada com sucesso',
        'productCreated' => 'Produto criado com sucesso',
        'productList' => 'Lista de produtos gerada com sucesso',
        'userCreated' => 'Usuário criado com sucesso',
        'webSourceList' => 'Lista de web gerada com sucesso',
        'productWebSourceList' => 'Lista de web gerada com sucesso',
        'passwordAltered' => 'Senha alterada com sucesso',
        'productDeleted' => 'Produto deletado com sucesso'
    ],
];