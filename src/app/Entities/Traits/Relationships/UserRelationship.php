<?php

namespace App\Traits\Relationships;

use App\Entities\User;

trait UserRelationship {

    /**
     * Retorna os produtos relacionados ao produto.
     *
     * @return string
     */
    public function transactions()
    {
        return $this->belongsToMany(User::class, 'transactions', 'payer', 'payee');
    }
}