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
use app\services\auth\AuthService;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(UserRepository $userRepository, AuthService $authService)
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    /**
     * @return string
     * @throws \Chiron\Http\Exception\Client\ForbiddenHttpException
     */
    public function index()
    {
        $this->authService->guard();

        return $this->toJson($this->userRepository->all());
    }

    public function login(AuthRequest $request)
    {
        if ($request->hasErrors()) {
            return $this->toJson($request->errors());
        }

        $response = $this->authService->login(
            $request->get('username'),
            $request->get('password')
        );

        return $this->toJson($response);
    }

    /**
     * @throws \Chiron\Http\Exception\Client\ForbiddenHttpException
     */
    public function logout()
    {
        $this->authService->guard();

    }
}