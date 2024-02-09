<?php

namespace App\Service;

use App\Model\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationService
{
    private const TOKEN_EXPIRATION = 60 * 60 * 24;

    public function __construct(private User $userModel)
    {
    }

    public function authenticate(string $email, string $password): User
    {
        $user = $this->userModel->getUserByEmail($email);
        if ($user === null || $password !== $user->password) {
            throw new \Exception(trans('messages.errors.invalidPassword'), 401);
        }

        return $user;
    }

    public function createToken(User $user): string
    {
        $payload = [
            "user" => $user->id,
            "email" => $user->email,
            "exp" => time() + self::TOKEN_EXPIRATION,
            "iat" => time(),
        ];

        return JWT::encode($payload, environment('JWTKEY'), 'HS256');
    }
}
