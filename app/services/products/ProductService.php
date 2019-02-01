<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 19:06
 */

namespace app\services\products;


use app\models\products\Product;
use app\models\products\ProductCategory;
use app\repositories\products\ProductRepository;
use Chiron\Http\Exception\Client\NotFoundHttpException;

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
        return $this->productRepository->findByCategoryId($id);
    }

    /**
     * Добавление продукта
     *
     * @param string $productName
     * @param array $categoryIds
     * @return array
     * @throws \Exception
     */
    public function add(string $productName, $categoryIds = []): array
    {
        $connection = Product::resolveConnection();
        $connection->beginTransaction();

        try {
            /** @var Product $product */
            $product = Product::create([
                'name' => $productName,
            ]);

            $product->categories()->attach($categoryIds);

            $connection->commit();

            return ['id' => $product->id];

        } catch (\Exception $exception) {
            $connection->rollBack();

            throw $exception;
        }
    }

    /**
     * @param int $id
     * @param $productName
     * @param $categoryIds
     * @return bool|int
     * @throws \Exception
     */
    public function edit(int $id, $productName, $categoryIds)
    {
        $connection = Product::resolveConnection();
        $connection->beginTransaction();

        try {
            $product = $this->findByIdOrFail($id);
            $product->fill(['name' => $productName]);
            $product->save();

            $product->categories()->sync($categoryIds);

            $connection->commit();
            return true;
        } catch (\Exception $exception) {
            $connection->rollBack();

            return false;
        }
    }

    /**
     * @param $id
     * @return bool|null
     * @throws NotFoundHttpException|\Exception
     */
    public function delete($id)
    {
        $product = $this->findByIdOrFail($id);
        return $product->delete();
    }

    public function addCategory($categoryName)
    {
        $category = ProductCategory::create([
            'name' => $categoryName
        ]);

        return ['id' => $category->id];
    }

    /**
     * @param int $id
     * @param $categoryName
     * @return bool
     * @throws NotFoundHttpException
     */
    public function editCategory(int $id, $categoryName)
    {
        $category = $this->findCategoryByIdOrFail($id);
        $category->fill(['name' => $categoryName]);

        return $category->save();
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws NotFoundHttpException|\Exception
     */
    public function deleteCategory(int $id)
    {
        $category = $this->findCategoryByIdOrFail($id);

        return $category->delete();
    }

    /**
     * @param int $id
     * @return Product
     * @throws NotFoundHttpException
     */
    protected function findByIdOrFail(int $id): Product
    {
        /** @var Product $product */
        if (($product = $this->productRepository->findById($id)) === null) {
            throw new NotFoundHttpException('Product not found!');
        }
        return $product;
    }

    /**
     * @param int $id
     * @return ProductCategory
     * @throws NotFoundHttpException
     */
    protected function findCategoryByIdOrFail(int $id): ProductCategory
    {
        /** @var ProductCategory $category */
        if (($category = $this->productRepository->findCategoryById($id)) === null) {
            throw new NotFoundHttpException('Category not found!');
        }
        return $category;
    }
}