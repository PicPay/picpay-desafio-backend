<?php

namespace App\Repositories;

use App\Models\User;

class AccountRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function getById(int $id): User
    {
        return $this->findBy('id', $id);
    }
}
