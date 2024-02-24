<?php

namespace App\Model;

use App\ORM\Model;
use App\Entity\UserId;
use App\ORM\Attributes\Table;
use App\ORM\Connection\Group\ConnectionGroup;
use App\ORM\Connection\Group\DefaultConnection;

#[Table('users')]
class User extends Model
{
    public function connectionGroup(): ConnectionGroup
    {
        return resolve(DefaultConnection::class);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->findWhere('email', "=", $email)->first();
    }

    public function createUser(\App\Entity\User $user): UserId
    {
        $result = $this->insert([
            'email' => ":email",
            'password' => ":password",
            'created_at' => "NOW()",
        ])
        ->addParam('email', $user->getEmail())
        ->addParam('password', $user->getPassword())
        ->execute();

        return new UserId($result->lastId());

    }

    public function alterPassword(UserId $userId, string $password): void
    {
        $this->update([
            'password' => ":password"
        ])
        ->addParam('password', $password)
        ->where('id', '=', $userId->getId())
        ->execute();
    }

}
