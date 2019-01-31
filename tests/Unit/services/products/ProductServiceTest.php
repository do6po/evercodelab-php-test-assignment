<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 19:40
 */

namespace Tests\Unit\services\products;

use app\models\products\Product;
use app\models\products\ProductCategory;
use app\models\products\ProductsCategories;
use app\services\products\ProductService;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * @var ProductService
     */
    private $service;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = app()->make(ProductService::class);
    }

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class,
        ];
    }

    /**
     * @throws \Exception
     */
    public function testAdd()
    {
        $productName = 'New product name';

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'name' => $productName,
        ]);

        $productId = $this->service->add($productName);

        $this->assertIsInt($productId);

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'name' => $productName,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function testAddWithCategories()
    {
        $productName = 'New product name';
        $categoryIds = [1, 2];
        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'name' => $productName,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => 5,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => 5,
            'product_cat_id' => 2,
        ]);

        $productId = $this->service->add($productName, $categoryIds);

        $this->assertIsInt($productId);

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'name' => $productName,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 2,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function testEdit()
    {
        $productId = 1;
        $productName = 'edited product name';
        $categoryIds = [1, 2];

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'id' => $productId,
            'name' => $productName,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 3,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 2,
        ]);

        $productId = $this->service->edit($productId, $productName, $categoryIds);
        $this->assertTrue($productId);

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'id' => $productId,
            'name' => $productName,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 2,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 3,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function testEditWithoutCategoryIds()
    {
        $productId = 1;
        $productName = 'edited product name';
        $categoryIds = [];

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'id' => $productId,
            'name' => $productName,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 3,
        ]);

        $productId = $this->service->edit($productId, $productName, $categoryIds);
        $this->assertTrue($productId);

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'id' => $productId,
            'name' => $productName,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $productId,
            'product_cat_id' => 3,
        ]);
    }

    public function testAddCategory()
    {
        $categoryName = 'new category name';
        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, [
            'name' => $categoryName,
        ]);

        $category = $this->service->addCategory($categoryName);
        $this->assertIsInt($category);

        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, [
            'name' => $categoryName,
        ]);
    }

    /**
     * @throws \Chiron\Http\Exception\Client\NotFoundHttpException
     */
    public function testEditCategory()
    {
        $categoryId = 1;
        $categoryName = 'edited category name';
        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, [
            'id' => $categoryId,
            'name' => $categoryName,
        ]);

        $category = $this->service->editCategory($categoryId, $categoryName);
        $this->assertTrue($category);

        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, [
            'id' => $categoryId,
            'name' => $categoryName,
        ]);
    }

    public function testDelete()
    {
        $productId = 1;
        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'id' => $productId,
        ]);

        $this->assertTrue($this->service->delete($productId));

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'id' => $productId,
        ]);
    }

    /**
     * @throws \Chiron\Http\Exception\Client\NotFoundHttpException
     */
    public function testDeleteCategory()
    {
        $categoryId = 1;
        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, [
            'id' => $categoryId,
        ]);

        $this->assertTrue($this->service->deleteCategory($categoryId));

        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, [
            'id' => $categoryId,
        ]);
    }
}