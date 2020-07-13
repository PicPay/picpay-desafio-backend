<?php

namespace App\Interfaces\User;

use App\Models\User\UsersWallet;

interface UserWalletInterface
{
    public function __construct(UsersWallet $wallet);
    public function findById(int $id): ?array;
    public function updateAmount(float $value, int $id): ?array;
    public function findByUserId(int $id): ?array;
}
