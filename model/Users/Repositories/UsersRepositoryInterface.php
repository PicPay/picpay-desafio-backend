<?php

namespace Model\Users\Repositories;

use Model\Users\Users;

interface UsersRepositoryInterface
{
    public function get($user_id) : Users;
}
