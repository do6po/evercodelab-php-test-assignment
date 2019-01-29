<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace app\http\controllers\auth;

use app\http\controllers\Controller;
use app\http\requests\auth\AuthRequest;
use app\repositories\auth\UserRepository;
use app\services\auth\UserService;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->toJson($this->userRepository->all());
    }

    public function login(AuthRequest $request)
    {
        if ($request->hasErrors()) {
            return $this->toJson($request->errors());
        }

        $response = $this->userService->login(
            $request->get('username'),
            $request->get('password')
        );

        return $this->toJson($response);
    }
}