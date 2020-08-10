<?php

namespace App\Http\Validators;

use Illuminate\Support\Arr;
use Model\Users\Repositories\UsersRepositoryInterface;

class UserIsShopKeeperValidator
{
    private $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        $user = $this->usersRepository->get($value);
        return !(bool) $user->is_shopkeeper;
    }
}
