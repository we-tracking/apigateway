<?php

namespace App\Exception;

use App\Validators\Errors;

class ValidationException extends \RuntimeException
{

    public function __construct(Errors $error, $field = null)
    {       
        $message = $error->first();
        if($field){
            $message = $error->errorsOnField($field)["message"];
        }

        parent::__construct($message, 422);
    }
    
}
