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
    ],

    'success' => [
        'authenticated' => 'Usuario autenticado com sucesso',
    ],
];