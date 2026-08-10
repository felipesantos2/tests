<?php

declare(strict_types=1);

namespace app\services;

use app\dtos\CreateUserDTO;
use app\dtos\DTO;
use app\entities\UserEntity;
use app\models\User;

class CreateUserService extends DTO
{
    public function __construct() {}

    public function createUser(DTO|CreateUserDTO $user)
    {
        $entity = new UserEntity($user);


        $userModel = new User();

        dd($entity);


        // $userModel->update($entity);

    }
}
