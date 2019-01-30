<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 27.01.2019
 * Time: 19:26
 */

namespace app\http\controllers\products;


use app\http\controllers\Controller;
use app\repositories\products\ProductRepository;
use app\services\products\ProductService;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return string
     */
    public function categories()
    {
        return $this->toJson(
            $this->productService->categories()
        );
    }

    /**
     * @param int $categoryId
     * @return string
     */
    public function productsByCategoryId(int $categoryId)
    {
        return $this->toJson(
            $this->productService->getByCategoryId($categoryId)
        );
    }
}