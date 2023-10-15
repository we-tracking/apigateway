<?php

namespace Source\Http\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Source\Request\User;
use Source\Request\Request;

class Auth{

    public function handle(Request $request){
        $token = $request->getHeaders()['HTTP_AUTHORIZATION'] ?? null;
        if($token){
            $token = str_replace("Bearer ", "", $token);    
            try{
                $decode = JWT::decode($token, new Key(getenv('APP_KEY'), getenv('ENCODE')));
                $request->setUserResolver(fn() => new User(
                    $decode->id
                ));

                container()->bind(Request::class, fn() => $request);
                return true;
            }catch(\Throwable){}
            
        }

        throw new \Exception("Usuario nao autenticado");
    }
}