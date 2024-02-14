<?php

namespace App\Controller;

use App\Http\Response\Response;
use App\Input\UserAuthenticationInput;
use App\Service\AuthenticationService;
use App\Http\Response\ResponseInterface;

class AuthenticationController
{
  public function auth(
    UserAuthenticationInput $input,
    AuthenticationService $authenticationService
  ): ResponseInterface {

    $user = $authenticationService->authenticate(
      $input->request()->email,
      $input->request()->password
    );

    return Response::json([
      "status" => true,
      "message" => trans('messages.success.authenticated'),
      "data" => [
        "token" => $authenticationService->createToken($user)
      ]
    ]);
  }

}