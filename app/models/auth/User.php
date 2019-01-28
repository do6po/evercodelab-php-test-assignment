<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:30
 */

namespace app\models\auth;

use app\helpers\HashHelper;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string username
 * @property string password
 * @property string token
 * @property string created_at
 * @property string updated_at
 *
 */
class User extends Model
{
    const TABLE_NAME = 'users';

    protected $fillable = [
        'username',
        'password',
        'token',
    ];

    protected $visible = ['username'];

    public function setPassword(string $password)
    {
        $this->password = md5($password);
    }

    public function comparePassword(string $password)
    {
        return $this->password === md5($password);
    }

    public function generateKey()
    {
        $this->token = HashHelper::generate();
    }
}