<?php

namespace Database\Seeds;

class Users extends \Database\Seed
{

    public function handle(): void
    {
        $this->create("users", [
            "email" => "test@gmail.com",
            "password" => "123456",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "deleted_at" => null
        ]);
    }

}