<?php

namespace App\Entity;

class UserAuthenticaded
{
    public function __construct(
        private UserId $userId,
        private string $email,
        private string $accessTime,
        private string $expTime
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

    public function getAccessTime(): string
    {
        return $this->accessTime;
    }

    public function getExpTime(): string
    {
        return $this->expTime;
    }
}
