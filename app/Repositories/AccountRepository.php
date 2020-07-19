<?php

namespace App\Repositories;

use App\Models\User;

class AccountRepository extends BaseRepository
{
    public function create(array $attributes): User
    {
        $user = new User($attributes);

        $user->save();

        return $user;
    }
}
