<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 3:56
 */

namespace Tests\Fixtures\models;

use app\models\products\ProductsCategories;
use Tests\Fixtures\ActiveFixture;

class ProductsCategoriesFixture extends ActiveFixture
{
    public $tableName = ProductsCategories::TABLE_NAME;

    public $dependencies = [
        ProductFixture::class,
        ProductCategoryFixture::class,
    ];

    public $dataFile = __DIR__.'/../data/products_categories.php';
}