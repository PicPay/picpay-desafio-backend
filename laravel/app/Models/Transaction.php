<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = [
        "value",
        "payer_wallet_id",
        "payee_wallet_id",
    ];

    /**
     * @return BelongsTo
     */
    public function payerWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, "payer_wallet_id");
    }

    /**
     * @return BelongsTo
     */
    public function payeeWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, "payee_wallet_id");
    }
}
