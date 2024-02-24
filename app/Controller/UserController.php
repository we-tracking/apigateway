<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserId;
use App\Service\UserService;
use App\Http\Response\Response;
use App\Input\UserCreationInput;
use App\Entity\UserAuthenticaded;
use App\Input\AlterPasswordInput;
use App\Http\Response\ResponseInterface;

class UserController
{
  public function create(UserCreationInput $input, UserService $userService): ResponseInterface
  {
    $user = $userService->create(
      new User(
        new UserId(),
        $input->request()->inputs('email'),
        $input->request()->inputs('password')
      )
    );

    return Response::json([
      "message" => trans('messages.success.userCreated'),
      "data" => ["id" => $user->getId()]
    ]);
  }

  public function alterPassword(
    AlterPasswordInput $input, 
    UserService $userService, 
    UserAuthenticaded $userAuthenticaded
    ): ResponseInterface
  {
  
    $userService->alterPassword(
      $userAuthenticaded->getUserId(),
      $input->request()->inputs('password')
    );

    return Response::json([
      "message" => trans('messages.success.passwordAltered')
    ]);

  }

}