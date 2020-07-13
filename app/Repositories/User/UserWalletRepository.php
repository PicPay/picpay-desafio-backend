<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserWalletInterface;
use App\Models\User\UsersWallet;


class UserWalletRepository implements UserWalletInterface
{
    protected $model;

    /**
     * Handle __construct
     *
     * @param UsersWallet $userWallet
     */
    public function __construct(UsersWallet $userWallet)
    {
        $this->model = $userWallet;
    }

    /**
     * Find by id
     *
     * @param integer $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        return $this->model::find($id)->toArray();
    }

    /**
     * Increase/Decrease wallet amount
     *
     * @param float $value
     * @param integer $id
     * @return array|null
     */
    public function updateAmount(float $value, int $id): ?array
    {
        $wallet = $this->model::find($id);

        $wallet->amount = $value;

        $wallet->save();

        return $wallet->toArray();
    }

    /**
     * get wallet by user id
     *
     * @param integer $id
     * @return array|null
     */
    public function findByUserId(int $id): ?array
    {
        return $this->model::where("user_id", $id)
            ->first()
            ->toArray();
    }
}