<?php

namespace Source\Validators\Handlers;

class IsArray{

    public function validate($value) : bool{
      return is_array($value);
    }
}