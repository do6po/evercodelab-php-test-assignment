<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 19:57
 */

namespace Tests\Unit\http\controllers\products;


use app\http\controllers\products\ProductCrudController;
use app\http\requests\products\ProductRequest;
use app\models\products\Product;
use app\models\products\ProductCategory;
use app\models\products\ProductsCategories;
use JeffOchoa\ValidatorFactory;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\Helpers\traits\RequestGenerator;
use Tests\TestCase;

class ProductCrudControllerTest extends TestCase
{
    use RequestGenerator;

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class
        ];
    }

    /**
     * @param $id
     * @dataProvider deleteDataProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function testDelete($id)
    {
        $controller = $this->makeController();

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id
        ]);

        $result = $controller->delete($id);
        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id
        ]);
    }

    public function deleteDataProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }

    /**
     * @param $id
     * @dataProvider deleteCategoryDataProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function testDeleteCategory($id)
    {
        $controller = $this->makeController();

        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_cat_id' => $id
        ]);

        $result = $controller->deleteCategory($id);
        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);

        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_cat_id' => $id
        ]);
    }

    public function deleteCategoryDataProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }

    /**
     * @throws \Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\validations\RequestValidationException
     */
    public function testEdit()
    {
        $id = 1;
        $newProductName = 'edited product name';
        $newData = [
            'id' => $id,
            'name' => $newProductName,
        ];

        $oldData = [
            'id' => $id,
            'name' => 'product 1',
        ];

        $this->assertDatabaseHas(Product::TABLE_NAME, $oldData);
        $this->assertDatabaseMissing(Product::TABLE_NAME, $newData);

        $request = $this->genRequest($newData);
        $controller = $this->makeController();
        $factory = app()->make(ValidatorFactory::class);

        $controller->edit($id, new ProductRequest($request, $factory));

        $this->assertDatabaseMissing(Product::TABLE_NAME, $oldData);
        $this->assertDatabaseHas(Product::TABLE_NAME, $newData);
    }

    /**
     * @throws \Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\validations\RequestValidationException
     */
    public function testEditWithDifferentCategoryIds()
    {
        $id = 1;
        $newProductName = 'edited product name';
        $newData = [
            'id' => $id,
            'name' => $newProductName,
        ];

        $newCategoryIds = ['categoryIds' => [2, 4]];

        $oldData = [
            'id' => $id,
            'name' => 'product 1',
        ];

        $this->assertDatabaseHas(Product::TABLE_NAME, $oldData);
        $this->assertDatabaseMissing(Product::TABLE_NAME, $newData);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 3,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 2,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 4,
        ]);

        $request = $this->genRequest(array_merge($newData, $newCategoryIds));
        $controller = $this->makeController();
        $factory = app()->make(ValidatorFactory::class);

        $controller->edit($id, new ProductRequest($request, $factory));

        $this->assertDatabaseMissing(Product::TABLE_NAME, $oldData);
        $this->assertDatabaseHas(Product::TABLE_NAME, $newData);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 1,
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 3,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 2,
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id,
            'product_cat_id' => 4,
        ]);
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeController(): ProductCrudController
    {
        $controller = app()->make(ProductCrudController::class);
        return $controller;
    }
}