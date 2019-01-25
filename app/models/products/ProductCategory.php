<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 0:49
 */

namespace app\models\products;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string $name
 *
 * @package app\models\products
 */
class ProductCategory extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}