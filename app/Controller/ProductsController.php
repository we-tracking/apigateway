<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Http\Response\Response;
use App\Service\ProductService;
use App\Entity\UserAuthenticaded;
use App\Input\CreateProductInput;
use App\Http\Request\RequestInterface;
use App\Http\Response\ResponseInterface;
use App\Service\WebSourceService;

class ProductsController
{
  public function __construct(
    private ProductService $productService,
    private WebSourceService $webSourceService
  ) {
  }

  public function list(
    UserAuthenticaded $user
  ): ResponseInterface {
    
    $products = $this->productService->listUserProducts($user->getUserId());
    return Response::json([
      "message" => trans('messages.success.productList'),
      "data" => $products->toArray()
    ]);
  }


  public function create(
    CreateProductInput $input,
    UserAuthenticaded $user
  ): ResponseInterface {

    $inputs = $input->request()->all();
    $productId = $this->productService->createProduct(
      new Product(
        new ProductId(),
        $inputs['name'],
        $inputs['ean'],
        $inputs['imagePath'],
        $user->getUserId()
      )
    );
    
    if(isset($inputs['webSources'])){
        $this->webSourceService->createProductWebSource(
          $productId,
          $inputs['webSources']
        );
    }   

    return Response::json([
      "message" => trans('messages.success.productCreated'),
      "data" => [
        "id" => $productId->getId()
      ]
    ]);
  }
}
