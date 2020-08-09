<?php

namespace Model\Users\Repositories;

use Model\Users\Repositories\UsersRepositoryInterface;
use Model\Users\Users;

class UsersRepository implements UsersRepositoryInterface
{
    private $model;

    public function __construct(Users $model)
    {
        $this->model = $model;
    }

    public function get($user_id) : Users
    {
        return $this->model->findOrFail($user_id);
    }

    public function addCredit($user_id,$amount) : Users
    {
        $user = $this->get($user_id);
        $user->credit_balance += $amount;
        $user->save();
        return $user;
    }

    public function withdrawCredit($user_id,$amount) : Users
    {
        $user = $this->get($user_id);
        if($user->credit_balance < $amount){
            throw new \Exception("User does not have enough credit");
        }
        $user->credit_balance -= $amount;
        $user->save();
        return $user;
    }
}
