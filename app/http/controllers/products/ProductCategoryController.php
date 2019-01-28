<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:25
 */

namespace app\http\controllers\products;


use app\http\controllers\Controller;
use app\repositories\products\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
    /**
     * @var ProductCategoryRepository
     */
    private $categoryRepository;

    public function __construct(ProductCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return $this->toJson($this->categoryRepository->all());
    }
}