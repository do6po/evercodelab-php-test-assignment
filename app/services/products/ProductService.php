<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 19:06
 */

namespace app\services\products;


use app\repositories\products\ProductRepository;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function categories()
    {
        return $this->productRepository->categories();
    }

    /**
     * @param int $id
     * @return \app\models\products\Product[]|\Illuminate\Support\Collection
     */
    public function getByCategoryId(int $id)
    {
        return $this->productRepository->getByCategoryId($id);
    }
}