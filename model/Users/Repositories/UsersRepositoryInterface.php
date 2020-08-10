<?php

namespace Model\Users\Repositories;

use Model\Users\Users;

interface UsersRepositoryInterface
{
    public function get($user_id): Users;
    public function addCredit($user_id, $amount): Users;
    public function withdrawCredit($user_id, $amount): Users;
}
