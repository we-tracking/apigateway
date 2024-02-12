<?php

namespace App\Http\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Entity\UserId;
use App\Entity\UserAuthenticaded;
use App\Container\ContainerInterface;
use App\Exception\ForbiddenException;
use App\Routes\Middleware\Middleware;
use App\Http\Request\RequestInterface;

class AuthMiddleware implements Middleware
{

    public function __construct(
        private RequestInterface $request,
        private ContainerInterface $container
    ) {
    }

    public function before(): void
    {
        if (!$user = $this->getTokenDecoded()) {
            throw new ForbiddenException(trans('auth.invalidToken'));
        }

        if ($user['exp'] < time()) {
            throw new ForbiddenException(trans('auth.expiredToken'));
        }

        $this->container->bind(
            UserAuthenticaded::class,
            fn() => new UserAuthenticaded(
                new UserId($user['user']),
                $user['email'],
                $user['iat'],
                $user['exp']
            )
        );
    }

    public function after(): void
    {
        return;
    }

    private function getToken(): ?string
    {
        return str_replace("Bearer ", "", $this->request->getHeaders()['HTTP_AUTHORIZATION'] ?? "");
    }

    private function getTokenDecoded(): array|bool
    {
        $token = $this->getToken();
        if ($token === null) {
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key(environment('JWTKEY'), 'HS256'));
        } catch (\Throwable $e) {
            return false;
        }

        return (array) $decoded;
    }
}

