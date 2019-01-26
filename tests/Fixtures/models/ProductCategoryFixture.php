<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 1:09
 */

namespace Tests\Fixtures\models;

use app\models\products\ProductCategory;
use Tests\Fixtures\ActiveFixture;

class ProductCategoryFixture extends ActiveFixture
{
    public $dataFile = __DIR__ . '/../data/product_categories.php';

    public $tableName = ProductCategory::TABLE_NAME;
}