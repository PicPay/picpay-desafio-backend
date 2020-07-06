<?php

namespace App\Entities;

use App\Traits\Scopes\UserScope;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Mutators\UserMutator;
use App\Traits\Relationships\UserRelationship;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UserRelationship, UserMutator, UserScope, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'document',
        'email',
        'password',
        'type',
        'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
