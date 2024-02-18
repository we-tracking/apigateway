<?php

namespace App\Entity;

class User{

    public function __construct(
        private UserId $userId,
        private string $email,
        private string $password,
    ){
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}