<?php

namespace App;

use DB;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VerifyTransactionTrait;
use App\Traits\NotificationTrait;

class Balance extends Model
{
    use VerifyTransactionTrait, NotificationTrait;

    public function withdraw(float $value) : Array
    {
        try {
            DB::beginTransaction();

            // verificar a transação com o api externa aqui antes de salvar
            $verify = $this->verify();
            if(!$verify['success']){
                return [
                    'success' => false,
                    'message' => $verify['message']
                ];
            }
            $verify = $this->verify();
            if(!$verify['success']){
                return [
                    'success' => false,
                    'message' => $verify['message']
                ];
            }

            if($this->amount < $value){
                return [
                    'success' => false,
                    'message' => 'Saldo insuficiente'
                ];
            }

            $totalBefore = $this->amount ?? 0;
            $this->amount -= number_format($value, 2, '.', '');
            $withdraw = $this->save();

            $transaction = auth()->user()->transactions()->create([
                'type'          => 'O', 
                'amount'        => $value, 
                'total_before'  => $totalBefore, 
                'total_after'   => $this->amount,
                'date'          => date('Ymd'),
            ]);

            if($withdraw && $transaction){
                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Sucesso ao retirar'
                ];
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => 'Falha ao retirar'
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        }
    }
    
    public function deposit(float $value) : Array
    {
        try {
            DB::beginTransaction();

            // verificar a transação com o api externa aqui antes de salvar
            $verify = $this->verify();
            if(!$verify['success']){
                return [
                    'success' => false,
                    'message' => $verify['message']
                ];
            }

            $totalBefore = $this->amount ?? 0;
            $this->amount += number_format($value, 2, '.', '');
            $deposit = $this->save();

            $transaction = auth()->user()->transactions()->create([
                'type'          => 'I', 
                'amount'        => $value, 
                'total_before'  => $totalBefore, 
                'total_after'   => $this->amount,
                'date'          => date('Ymd'),
            ]);

            if($deposit && $transaction){
                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Sucesso ao recarregar'
                ];
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => 'Falha ao recarregar'
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];
        }
    }

    public function transfer(float $value, User $sender) : Array
    {
        try {
            DB::beginTransaction();

            // verificar a transação com o api externa aqui antes de salvar
            $verify = $this->verify();
            if(!$verify['success']){
                return [
                    'success' => false,
                    'message' => $verify['message']
                ];
            }

            if($this->amount < $value){
                return [
                    'success' => false,
                    'message' => 'Saldo insuficiente'
                ];
            }

            /********************************************
             *      Atualizar o próprio saldo
             *******************************************/
            $totalBefore = $this->amount ?? 0;
            $this->amount -= number_format($value, 2, '.', '');
            $transfer = $this->save();

            $transaction = auth()->user()->transactions()->create([
                'type'                  => 'T', 
                'amount'                => $value, 
                'total_before'          => $totalBefore, 
                'total_after'           => $this->amount,
                'date'                  => date('Ymd'),
                'user_id_transaction'   => $sender->id,
            ]);

            /********************************************
             *      Atualizar o saldo do recebedor
             *******************************************/
            $senderBalance = $sender->balance()->firstOrCreate([]);
            $totalBeforeSender = $senderBalance->amount ?? 0;
            $senderBalance->amount += number_format($value, 2, '.', '');
            $transferSender = $senderBalance->save();

            $transactionSender = $sender->transactions()->create([
                'type'                  => 'I', 
                'amount'                => $value, 
                'total_before'          => $totalBeforeSender, 
                'total_after'           => $senderBalance->amount,
                'date'                  => date('Ymd'),
                'user_id_transaction'   => auth()->user()->id,
            ]);
            
            if($transfer && $transaction && $transferSender && $transactionSender){
                // envia notificação com api externa
                $notify = $this->notify();
                if(!$notify['success']){
                    DB::rollBack();

                    return [
                        'success' => false,
                        'message' => $notify['message']
                    ];
                }

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Sucesso ao transferir'
                ];
            }
            
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        }
    }
}
