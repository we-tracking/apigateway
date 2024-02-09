<?php

namespace App\Model;

use App\ORM\Model;
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
        return $this->findWhere('email', "=", "'$email'")->first();
    }

}
