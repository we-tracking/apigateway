<?php

namespace Source\Connection;

use Source\Log\Log;

/**
 * Conexao com o banco de dados
 */
class DBConnect extends \ClanCats\Hydrahon\Builder
{

    protected static $connection;

    public static function PDOSetConnection()
    {

        $host = getenv("DB_HOST");
        $user = getenv("DB_USER");
        $pass = getenv("DB_PASS");
        $dbName = getenv("DB_NAME");
        $PDOConfig = "mysql:host=$host;dbname=$dbName;charset=utf8";
        self::$connection = new \PDO($PDOConfig, $user, $pass);
        $connection = self::$connection;
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //retornará uma exeção caso algo de errado

        return new \ClanCats\Hydrahon\Builder("mysql", function ($query, $queryString, $queryParameters) use ($connection) {
            $statement = $connection->prepare($queryString);
            $statement->execute($queryParameters);
            $errors = $connection->errorInfo();
            
            if (!is_null($errors[2])) {
                Log::critical($errors[2], $errors);
            }
            if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface) {
                return $statement->fetchAll(\PDO::FETCH_OBJ); #Aqui retorna o resultado da query Como um objeto
            } elseif ($query instanceof \ClanCats\Hydrahon\Query\Sql\Insert) {
                return $connection->lastInsertId();
            } else {
                return $statement->rowCount();
            }
        });
    }

    public static function rawQuery($query){
        $connection = self::$connection;
        $statement = $connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
        
    }

    public static function getConnection()
    {
        return DBConnect::PDOSetConnection();
    }
}
