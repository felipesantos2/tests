<?php

declare(strict_types=1);

namespace app\controllers;

use app\dtos\CreateUserDTO;
use app\exceptions\BasicErrorException;
use app\services\CreateUserService;
use Exception;

class UserController extends Controller
{
    private ?CreateUserDTO $userDTO = null;

    private ?CreateUserService $userService = null;

    public function __construct()
    {
        $this->userDTO = new CreateUserDTO();
        $this->userService = new CreateUserService();
    }

    public function index()
    {
        echo '<br>UserController<br>';

        // exit(1);

        try {
            $this->userDTO->filled(
                'Felipe Pinheiro dos Santos',
                'santospinheiro6gmail.com',
                '12315466799',
                '123456789',
                0,
            );

            $this->userService->createUser($this->userDTO);

            return 'ok';

        } catch (Exception|BasicErrorException $e) {
            http_response_code($e->statusCode());
            echo $e->render();

            return;
        }
    }

    public function store()
    {
        echo '1';
    }
}
