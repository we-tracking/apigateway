<?php

namespace App\Service;

use App\Entity\UserId;
use App\Model\User;

class UserService
{
    public function __construct(private User $user){
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->user->getUserByEmail($email);
    }

    public function alterPassword(UserId $userId, string $password): void
    {
        $this->user->alterPassword($userId, $password);
    }

    public function create(\App\Entity\User $user): UserId
    {
        if($this->findUserByEmail($user->getEmail()) !== null) {
            throw new \Exception(trans('messages.errors.userAlreadyExists'));
        }

        return $this->user->createUser($user);
    }
}