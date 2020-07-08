<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as Guzzle;
use Exception;

class Transaction extends Model
{

    const AUTHORIZATION_URL = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";
    const NOTIFICATION_URL = "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            try {
                $model->validateTransactionRequest();
                $model->payer->balance -= $model->value;
                $model->payer->save();
                $model->payee->balance += $model->value;
                $model->payee->save();
                $model->notifyPayee();
            } catch (\Exception $e) {
                throw $e;
            }
        });
    }

    public function payer()
    {
        return $this->belongsTo(\App\User::class, 'payer_id');
    }

    public function payee()
    {
        return $this->belongsTo(\App\User::class, 'payee_id');
    }

    /**
     * Validate all the rules of a transaction
     *
     * @return void
     */
    public function validateTransactionRequest()
    {
        $this->validateStorePayer();
        $this->validateSameUser();
        $this->validatePayerBalance();
        $this->checkAuthorization();
    }

    /**
     * Validate if the Payer is not a store
     *
     * @return void
     */
    public function validateStorePayer()
    {
        if ($this->payer->type === User::TYPE_STORE) {
            throw new Exception("Stores cannot do transactions!");
        }
        return true;
    }

    /**
     * Validate if the Payee and the Payer are not the same user
     *
     * @return void
     */
    public function validateSameUser()
    {
        if ($this->payer->id === $this->payee->id) {
            throw new Exception("The Payee and the Payer cannot be the same!");
        }
    }

    /**
     * Validate if the Payer have enought balance
     *
     * @return void
     */
    public function validatePayerBalance()
    {
        if ($this->payer->balance < $this->value) {
            throw new Exception("Insufficient balance!");
        }
    }

    /**
     * Validate if the transaction is authorized
     *
     * @return void
     */
    public function checkAuthorization()
    {
        $client = new Guzzle;
        $authorization = $client->request('GET', self::AUTHORIZATION_URL);
        $response = json_decode($authorization->getBody());
        if (!isset($response->message) || $response->message !== "Autorizado") {
            throw new Exception("Transaction not authorized!");
        }
    }

    /**
     * Notify the Payee using the external notification service
     */
    public function notifyPayee()
    {
        $client = new Guzzle;
        $authorization = $client->request('GET', self::NOTIFICATION_URL);
        $response = json_decode($authorization->getBody());
        if (isset($response->message) && $response->message === "Enviado") {
            return true;
        }

        // Criar nova tentativa de notificação através do Laravel Queue ou sistema externo similar
    }
}
