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

class ProductsController
{
  public function __construct(
    private ProductService $productService
  ) {
  }

  public function list(
    RequestInterface $request,
    UserAuthenticaded $user
  ): ResponseInterface {
    
    $products = $this->productService->listUserProducts($user->getUserId());
    return Response::json([
      "message" => "List of products",
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
    return Response::json([
      "message" => "Product created",
      "data" => [
        "id" => $productId->getId()
      ]
    ]);
  }


}