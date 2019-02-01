<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 12:54
 */

namespace app\http\controllers\products;


use app\http\controllers\Controller;
use app\http\requests\products\CategoryRequest;
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

    /**
     * @param CategoryRequest $request
     * @return mixed
     */
    public function addCategory(CategoryRequest $request)
    {
        $categoryName = $request->get('name');

        return $this->productService->addCategory($categoryName);
    }

    /**
     * @param int $id
     * @param ProductRequest $request
     * @return bool|int
     * @throws \Exception
     */
    public function edit(int $id, ProductRequest $request)
    {
        $productName = $request->get('name');
        $categoryIds = $request->get('categoryIds');

        return $this->productService->edit($id, $productName, $categoryIds);
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @return bool
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function editCategory(int $id, CategoryRequest $request)
    {
        $categoryName = $request->get('name');

        return $this->productService->editCategory($id, $categoryName);
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function delete(int $id)
    {
        return $this->productService->delete($id);
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function deleteCategory(int $id)
    {
        return $this->productService->deleteCategory($id);
    }
}