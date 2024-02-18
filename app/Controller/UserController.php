<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserId;
use App\Service\UserService;
use App\Http\Response\Response;
use App\Input\UserCreationInput;
use App\Http\Request\RequestInterface;
use App\Http\Response\ResponseInterface;

class UserController
{
  public function create(UserCreationInput $request, UserService $userService): ResponseInterface
  {
    $user = $userService->create(
      new User(
        new UserId(),
        $request->request()->inputs('email'),
        $request->request()->inputs('password')
      )
    );

    return Response::json([
      "message" => "User created",
      "data" => ["id" => $user->getId()]
    ]);
  }

}