<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfer';
    protected $fillable = ['payer_id', 'payee_id', 'value', 'cancelled', 'processed', 'authorization_status'];
    protected $observables = [
        'authorized',
        'cancelled',
    ];

    public function authorized()
    {
        $this->fireModelEvent('authorized', false);
    }

    public function cancelled()
    {
        $this->fireModelEvent('cancelled', false);
    }
}
