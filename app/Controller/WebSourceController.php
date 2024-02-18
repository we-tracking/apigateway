<?php

namespace App\Controller;

use App\Entity\ProductId;
use App\Http\Response\Response;
use App\Service\WebSourceService;
use App\Http\Request\RequestInterface;
use App\Http\Response\ResponseInterface;

class WebSourceController
{
  public function __construct(private WebSourceService $webSourceService){
  }

  public function list(): ResponseInterface
  { 
    return Response::json([
      "message" => trans('messages.success.webSourceList'),
      "data" => $this->webSourceService->list()
    ]);
  }

  public function listProductWebSource(RequestInterface $request): ResponseInterface
  {

    $products = $this->webSourceService->getWebSourceFromProductId(
      new ProductId($request->route()->parameter('productId'))
    );

    if($products == null){
      throw new \Exception(trans('messages.errors.productNotFound'));
    }
      return Response::json([
        "message" => trans('messages.success.webSourceList'),
        "data" => $products->toArray()
      ]);
  }

}