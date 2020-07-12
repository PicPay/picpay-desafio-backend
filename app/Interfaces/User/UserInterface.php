<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function __construct(User $User);
    public function create(array $UserPayload);
}