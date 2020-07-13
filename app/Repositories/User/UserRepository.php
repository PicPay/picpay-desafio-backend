<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;


class UserRepository implements UserInterface
{
    protected $model;

    /**
     * Handle __construct
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Undocumented function
     *
     * @param array $payloadData
     * @return void
     */
    public function create(array $payloadData)
    {
        $User = $this->model::create($payloadData);

        return $User->save();
    }
}