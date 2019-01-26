<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 15:20
 */

namespace Tests\Unit\products;

use app\models\products\Product;
use app\models\products\ProductCategory;
use app\models\products\ProductsCategories;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\TestCase;

class ProductsCategoriesTest extends TestCase
{
    public function fixtures()
    {
        return [
            ProductsCategoriesFixture::class,
        ];
    }

    /**
     * @param $productId
     * @param $categoriesCount
     *
     * @dataProvider createRelationsDataProvider
     */
    public function testGetCategoriesRelations($productId, $categoriesCount)
    {
        /** @var Product $product */
        $product = Product::find($productId);
        $this->assertNotNull($product);

        $this->assertEquals($categoriesCount, $product->categories()->count());
    }

    public function createRelationsDataProvider()
    {
        return [
            [1, 2],
            [2, 3],
            [3, 2],
            [4, 1],
        ];
    }

    /**
     * @param $categoryId
     * @param $productsCount
     *
     * @dataProvider productsRelationDataProvider
     */
    public function testProductsRelations($categoryId, $productsCount)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::find($categoryId);
        $this->assertNotNull($category);

        $this->assertEquals($productsCount, $category->products()->count());
    }

    public function productsRelationDataProvider()
    {
        return [
            [1, 2],
            [2, 1],
            [3, 3],
            [4, 2],
        ];
    }

    public function testSaveRelations()
    {
        $productId = 1;
        $categoryId = 2;
        $data = [
            'product_id' => $productId,
            'product_cat_id' => $categoryId,
        ];

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, $data);

        /** @var Product $product */
        $product = Product::find($productId);
        $this->assertNotNull($product);

        $this->assertEquals(2, $product->categories()->count());

        /** @var ProductCategory $category */
        $category = ProductCategory::find($categoryId);
        $this->assertNotNull($category);

        $product->categories()->save($category);
        $this->assertEquals(3, $product->categories()->count());

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, $data);
    }

    /**
     * @expectedException \PDOException
     */
    public function testUniqueRelation()
    {
        $productId = 1;
        $categoryId = 1;
        $data = [
            'product_id' => $productId,
            'product_cat_id' => $categoryId,
        ];

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, $data);
        $this->assertEquals(1, $this->getProductsCategoriesRelationCount($productId, $categoryId));

        /** @var Product $product */
        $product = Product::find($productId);
        /** @var ProductCategory $category */
        $category = ProductCategory::find($categoryId);
        $product->categories()->save($category);

        $this->assertEquals(1, $this->getProductsCategoriesRelationCount($productId, $categoryId));
    }

    private function getProductsCategoriesRelationCount($productId, $categoryId)
    {
        return $this->db
            ->getConnection()
            ->table(ProductsCategories::TABLE_NAME)
            ->where('product_id', $productId)
            ->where('product_cat_id', $categoryId)
            ->count();
    }
}