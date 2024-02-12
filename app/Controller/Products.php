<?php

namespace App\Controller;

use App\Http\Request\RequestInterface;
use App\Http\Response\Response;

class Products
{
  public function list(RequestInterface $request)
  {
    return Response::json([
      "message" => "List of products"
    ]);
  }


  public function create(RequestInterface $request)
  {
    return Response::json([
      "message" => "Product created"
    ]);
  }


}