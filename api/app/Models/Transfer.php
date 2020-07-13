<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transfer
 * @package App\Models
 */
class Transfer extends Model
{
    public const STATUS_INVALID = 'invalid';
    public const STATUS_FAIL = 'fail';
    public const STATUS_SUCCEEDED = 'succeeded';

    protected $fillable = ['payer_id', 'payee_id', 'amount', 'status', 'message'];
    protected $hidden = [];
    protected $table = 'transfer';

    /**
     * Transfer constructor.
     * @param User $payer
     * @param User $payee
     * @param int $amount
     */
    public function __construct(User $payer, User $payee, int $amount)
    {
        $this->payer_id = $payer->id;
        $this->payee_id = $payee->id;
        $this->amount = $amount;
    }

    /**
     * @param string $message
     * @return Transfer
     */
    public function invalidate(string $message): Transfer
    {
        $this->status = self::STATUS_INVALID;
        $this->message = $message;
        $this->save();

        return $this;
    }

    /**
     * @param string $message
     * @return Transfer
     */
    public function fail(string $message): Transfer
    {
        $this->status = self::STATUS_FAIL;
        $this->message = $message;
        $this->save();

        return $this;
    }

    /**
     * @return Transfer
     */
    public function succeed(): Transfer
    {
        $this->status = self::STATUS_SUCCEEDED;
        $this->save();

        return $this;
    }
}
