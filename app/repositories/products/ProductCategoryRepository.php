<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:40
 */

namespace app\repositories\products;


use app\models\products\ProductCategory;

class ProductCategoryRepository
{
    public function all()
    {
        return ProductCategory::all();
    }

    public function getById(int $id)
    {
        return ProductCategory::find($id);
    }
}