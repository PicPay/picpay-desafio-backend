<?php

namespace App\Models;

use App\Authorizations\TransferAuthorization;
use App\Enums\WalletTypeEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\UnauthorizedTransferException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $table = "wallets";
    protected $fillable = [
        "user_id",
        "balance",
        "type",
    ];
    protected $attributes = [
        "balance" => 0.0,
        "type" => WalletTypeEnum::USER_WALLET,
    ];

    public function isUserWallet(): bool
    {
        return $this->type === WalletTypeEnum::USER_WALLET;
    }

    public function isShopkeeperWallet(): bool
    {
        return $this->type === WalletTypeEnum::SHOPKEEPER_WALLET;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function purchaseTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id');
    }

    /**
     * @return HasMany
     */
    public function saleTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id');
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->purchaseTransactions->merge($this->saleTransactions);
    }

    /**
     * @param float $amount
     * @return bool
     * @throws InsufficientBalanceException
     * @throws InvalidOperationException
     * @throws GuzzleException
     */
    private function isPayerAuthorized(float $amount): bool
    {
        $auth = new TransferAuthorization($this, $amount);
        if (!env("APP_USE_MOCK", false)) {
            return true;
        }
        $json = json_decode($auth->getAuthorizationResponse()->getBody(), true);
        return is_array($json);
    }

    /**
     * @param float $amount
     */
    public function add(float $amount): void
    {
        $this->balance += $amount;
    }

    /**
     * @param float $amount
     * @throws InsufficientBalanceException
     * @throws InvalidOperationException
     * @throws UnauthorizedTransferException
     * @throws GuzzleException
     */
    public function subtract(float $amount): void
    {
        if (!$this->isPayerAuthorized($amount)) {
            throw new UnauthorizedTransferException("Retirada não pôde ser autorizada.");
        }
        $this->balance -= $amount;
    }
}
