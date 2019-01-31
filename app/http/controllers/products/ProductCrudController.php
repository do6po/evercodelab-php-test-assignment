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

    /**
     * @param ProductRequest $request
     * @return array|bool
     * @throws \Exception
     */
    public function add(ProductRequest $request)
    {
        $productName = $request->get('name');
        $categoryIds = $request->get('categoryIds');

        return $this->productService->add($productName, $categoryIds);
    }
}