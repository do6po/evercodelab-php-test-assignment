<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:30
 */

namespace app\models;

use app\helpers\HashHelper;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string username
 * @property string password
 * @property string key
 *
 */
class User extends Model
{
    protected $fillable = [
        'username',
        'password',
        'key',
    ];

    public function generateKey()
    {
        $this->key = HashHelper::random();
    }
}