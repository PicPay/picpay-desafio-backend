<?php

namespace App\Repositories\Contracts\Users;

interface UsersRepositoryContract
{
    public function getAvailableWalletAmount($user_id);
    public function isCommonUser($user_id);
}
