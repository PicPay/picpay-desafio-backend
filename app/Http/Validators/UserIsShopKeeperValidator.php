<?php

namespace App\Http\Validators;

use Model\Users\Repositories\UsersRepositoryInterface;
use Illuminate\Support\Arr;

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
        return ! (boolean) $user->is_shopkeeper;
    }
}
