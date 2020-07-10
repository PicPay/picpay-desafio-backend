<?php

namespace App\Repositories\Contracts\Users;

interface UsersRepositoryContract
{
    public function getAvailableWalletAmount($user_id);

    public function isCommonUser($user_id);

    public function findUser($user_id);

    public function updateUser($user_id, array $data);
}
