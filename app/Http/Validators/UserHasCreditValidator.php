<?php

namespace App\Http\Validators;

use Illuminate\Support\Arr;
use Model\Users\Repositories\UsersRepositoryInterface;

class UserHasCreditValidator
{
    private $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        $amount = Arr::get($validator->getData(), 'value');
        $user = $this->usersRepository->get($value);
        return $user->credit_balance >= $amount;
    }
}
