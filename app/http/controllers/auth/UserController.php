<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace app\http\controllers\auth;


use app\http\controllers\Controller;
use app\repositories\auth\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->toJson($this->userRepository->all());
    }
}