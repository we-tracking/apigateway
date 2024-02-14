<?php

namespace App\Controller;

use App\Entity\ProductId;
use App\Http\Response\Response;
use App\Input\ListPriceByProduct;
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
      "message" => "List of prices by product",
      "data" => $this->productHistoryService->listByProduct(new ProductId($input->request()->productId))
    ]);
  }

}