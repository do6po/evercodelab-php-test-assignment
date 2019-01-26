<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 15:20
 */

namespace Tests\Unit\products;

use app\models\products\Product;
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
    public function testCreateRelations($productId, $categoriesCount)
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
}