<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\Users\Users;
use App\Repositories\Contracts\Users\UsersRepositoryContract;

class UsersRepository implements UsersRepositoryContract
{
    /**
     * @var Users
     */
    private $model;

    public function __construct()
    {
        $this->model = new Users;
    }

    public function getAvailableWalletAmount($user_id)
    {
        $wallet_amount = $this->model->select('wallet_amount')->where('id', $user_id)->first();
        if ($wallet_amount) {
            return $wallet_amount->wallet_amount;
        }
        return 0;
    }

    public function isCommonUser($user_id)
    {
        $user = $this->model->where('id', $user_id)->first();
        if($user) {
            return $user->is_common === 1; //true
        }
        return false;
    }
}
