<?php

namespace App\Controller;

use App\Http\Request\RequestInterface;
use App\Http\Response\Response;
use App\Service\WebSourceService;

class WebSourceController
{
  public function __construct(private WebSourceService $webSourceService){
  }

  public function list()
  { 
    return Response::json([
      "message" => "web source list",
      "data" => $this->webSourceService->list()
    ]);
  }

}