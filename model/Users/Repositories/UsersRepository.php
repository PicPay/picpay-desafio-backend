<?php

namespace Model\Users\Repositories;

use Model\Users\Repositories\UsersRepositoryInterface;
use Model\Users\Users;

class UsersRepository implements UsersRepositoryInterface
{
    private $model;

    public function __construct(Users $model)
    {
        $this->model = $model;
    }

    public function get($user_id) : Users
    {
        return $this->model->findOrFail($user_id);
    }
}
