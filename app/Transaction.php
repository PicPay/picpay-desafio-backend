<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type', 
        'amount', 
        'total_before', 
        'total_after', 
        'user_id_transaction',
        'date',
    ];

    public function type($type = null)
    {
        $types = [
            'I' => 'Entrada',
            'O' => 'Saque',
            'T' => 'Transferência',
        ];

        if(!$type){
            return $types;
        }

        if($this->user_id_transaction != null && $type == 'I'){
            return 'Recebido';
        }

        return $types[$type];

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userSender()
    {
        return $this->belongsTo(User::class, 'user_id_transaction');
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function search(Array $data, $totalPage)
    {
        $transactions = $this->where(function ($query) use ($data){
            if(isset($data['id'])){
                $query->where('id', $data['id']);
            }

            if(isset($data['date'])){
                $query->where('date', $data['date']);
            }

            if(isset($data['type'])){
                $query->where('type', $data['type']);
            }
        })
        // ->where('user_id', auth()->user()->id)
        ->userAuth()
        ->with(['userSender'])
        ->paginate($totalPage);
        // ->toSql(); dd($transactions);

        return $transactions;
    }

    public function scopeUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
