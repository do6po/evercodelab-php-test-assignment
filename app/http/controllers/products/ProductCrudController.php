<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 12:54
 */

namespace app\http\controllers\products;


use app\http\controllers\Controller;
use app\http\requests\products\ProductRequest;
use app\services\products\ProductService;

class ProductCrudController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(ProductRequest $request)
    {
//        if ($request->hasErrors()) {
//
//        }
//
//        return $this->toJson(
//            $this->productService->add($name, $categoryIds)
//        );
    }
}