<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 19:20
 */

namespace app\services\auth;


use app\models\auth\User;
use app\repositories\auth\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($username, $password)
    {
        $user = $this->userRepository->findByUsername($username);
        if (!is_null($user) && $user->comparePassword($password)) {
            return [
                'token' => $user->token,
            ];
        }

        return false;
    }
}