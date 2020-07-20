<?php
namespace Model\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
    protected $guarded = ['transaction_id'];

    public function payer()
    {
        return $this->hasOne(\Model\Users\Users::class,'user_id','payer_id');
    }

    public function payee()
    {
        return $this->hasOne(\Model\Users\Users::class,'user_id','payee_id');
    }

    public function status()
    {
        return $this->belongsTo(\Model\TransactionStatus\TransactionStatus::class,'transaction_status_id','transaction_status_id');
    }
}
