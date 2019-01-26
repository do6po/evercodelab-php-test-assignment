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

        /** @var Product $product */
        $product = Product::find($productId);
        $this->assertNotNull($product);

        $this->assertEquals(2, $product->categories()->count());

        /** @var ProductCategory $category */
        $category = ProductCategory::find($categoryId);
        $this->assertNotNull($category);

        $product->categories()->save($category);
        $this->assertEquals(3, $product->categories()->count());
    }
}