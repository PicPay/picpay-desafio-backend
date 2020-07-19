<?php
namespace Model\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $hidden = ['password'];
    protected $guarded = ['user_id'];
}
