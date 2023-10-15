<?php

namespace Source\Container;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class EnviromentSeup{

    public static bool $status = false;

    private static function jsonParse(){    

        return JWT::decode(
            json_decode(
                file_get_contents(
                    __DIR__ . "/config/enviroment.json"), true)["env"],
                    new Key( "10","HS256")
        );
    }

    public static function setEnviroment() : void{
        foreach(self::jsonParse() as $key => $value){
            putenv($key . "=" . $value);
        }
    }

}