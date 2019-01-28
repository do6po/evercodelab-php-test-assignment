<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:48
 */

namespace app\repositories\auth;


use app\models\auth\User;

class UserRepository
{
    public function getById(int $id)
    {
        return User::find($id);
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return User::all();
    }
}