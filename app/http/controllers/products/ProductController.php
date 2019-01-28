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

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->toJson($this->productRepository->all());
    }
}