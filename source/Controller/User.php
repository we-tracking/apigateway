<?php

namespace Source\Controller;

use Firebase\JWT\JWT;
use Source\Router\Request;
use Source\Model\User as UserModel;

class User{
    
    public function __construct(private UserModel $user){   

    }
    
    public function auth(Request $request){
        if($user = $this->user->findByEmail($request->email)){
            if($user->password == $request->password){
                return [
                    "usuario autenticado com sucesso",
                    "token" => JWT::encode([
                        "id" => $user->id,
                        "email" => $user->email,
                        "name" => $user->name
                    ], getenv('APP_KEY'), getenv('ENCODE'))
                ];
            }
        }

        throw new \Exception("usuario ou senha invalidos!");
    }

    public function register( Request $request){

        $this->user->insert(
            [
                "email" => $request->email,
                "password" => $request->password
            ]
            )->execute();
        return [
            "message" => "usuario registrado com sucesso!"
        ];
    }

}