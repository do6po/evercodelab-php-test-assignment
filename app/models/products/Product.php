<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 0:48
 */

namespace app\models\products;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property ProductCategory[] categories
 *
 * @package app\models\products
 */
class Product extends Model
{
    const TABLE_NAME = 'products';

    protected $fillable = ['name'];

    protected $visible = ['name'];

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            ProductsCategories::TABLE_NAME,
            'product_id',
            'product_cat_id'
        );
    }
}