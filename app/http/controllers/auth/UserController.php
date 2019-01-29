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
use app\services\auth\UserService;
use Illuminate\Http\Request;

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

    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $response = $this->userService->login($username, $password);

        return $this->toJson($response);
    }
}