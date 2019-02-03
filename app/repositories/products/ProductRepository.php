<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:40
 */

namespace app\repositories\products;


use app\models\products\Product;
use app\models\products\ProductCategory;
use Illuminate\Support\Collection;

class ProductRepository
{
    /**
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id)
    {
        return Product::find($id);
    }

    /**
     * @param ProductCategory $category
     * @return Collection
     */
    public function findByCategory(ProductCategory $category): Collection
    {
        return $category->products;
    }

    /**
     * @return ProductCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return ProductCategory::all();
    }

    /**
     * @param int $categoryId
     * @return ProductCategory|null
     */
    public function findCategoryById(int $categoryId)
    {
        return ProductCategory::find($categoryId);
    }
}