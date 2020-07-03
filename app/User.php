<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'id' , 'name', 'email', 'cpf', 'cnpj', 'type'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at', 'wallet',
    ];

    public static function verifyNotFoundUsers($usersIds) {
        $notFoundUsers = [];

        foreach ($usersIds as $key => $value) {
            $userData = self::getOne($value);
            if (!isset($userData)) {
                $notFoundUsers[] = $key;
            }
        }

        return $notFoundUsers;
    }

    public static function canDoTransaction($userId) {
        $userData = self::getOne($userId);

        if (!isset($userData)) {
            return false;
        }

        return $userData->type == 'user';
    }

    public static function getOne($userId)
    {
        return self::where('id', $userId)->first();
    }

    public static function details($userId) {
        $user = self::getOne($userId);

        if (empty($user)) {
            return [];
        }

        $user->wallet_balance = $user->wallet->balance;

        return [
            'details' => $user,
            'transactions' => Transaction::byUser($userId)
        ];
    }

    public static function verifyHaveBalance($userId, $transactionValue) {
        $user = self::getOne($userId);

        return $user->wallet->balance >= $transactionValue;
    }

    public function wallet() {
        return $this->hasOne('App\Wallet');
    }
}
