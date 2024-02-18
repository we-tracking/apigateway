<?php

namespace App\Controller;

use App\Entity\ProductId;
use App\Entity\WebSourceId;
use App\Http\Response\Response;
use App\Input\ListPriceByProduct;
use App\Http\Request\RequestInterface;
use App\Service\ProductHistoryService;
use App\Http\Response\ResponseInterface;

class ProductHistoryController
{
  public function __construct(
    private ProductHistoryService $productHistoryService
  ) {
  }

  public function listByProduct(
    ListPriceByProduct $input
  ): ResponseInterface {

    return Response::json([
      "message" => trans('messages.success.productPriceList'),
      "data" => $this->productHistoryService->listByProduct(new ProductId($input->request()->productId))
    ]);
  }

  public function listProductWebSourceHistory(RequestInterface $request): ResponseInterface
  {
    $products = $this->productHistoryService->getProductHistory(
      new ProductId($request->route()->parameter('productId')),
      new WebSourceId($request->route()->parameter('webSourceId'))
    );

    return Response::json([
      "message" => "",
      "data" => $products->toArray()
    ]);

  }

}