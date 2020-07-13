<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'document', 'isCompany', 'balance'];
    protected $hidden = ['password'];
    protected $table = 'user';

    /**
     * @param int $amount
     * @return bool|null
     */
    public function canTransfer(int $amount): ?bool
    {
        if ($this->isCompany == true) {
            return null;
        }

        return $this->balance >= $amount;
	}

    /**
     * @param int $amount
     * @return $this
     */
    public function addBalance(int $amount): User
    {
        $this->balance += $amount;
        $this->save();

        return $this;
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function removeBalance(int $amount): User
    {
        $this->balance -= $amount;
        $this->save();

        return $this;
    }
}
