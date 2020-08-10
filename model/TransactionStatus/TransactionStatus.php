<?php

namespace Model\TransactionStatus;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $table = 'transaction_status';
    protected $primaryKey = 'transaction_status_id';
    public $timestamps = false;
    protected $guarded = ['transaction_status_id'];
}
