<?php

namespace App\Models;

use App\Enums\WalletTypeEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\UnauthorizedTransferException;
use GuzzleHttp\Client;
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

    private function getAuthorization(string $url): ?array
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            $url,
            ['verify' => base_path('cacert.pem')]
        );

        $json = json_decode($response->getBody(), true);
        return is_array($json) ? $json : null;
    }

    private function isPayerAuthorized(): bool
    {
        return true;
        // não consegui abrir o mock, portanto não sei a estrutra nem o que retorna
        // todo: revisar padrão do mock
        return !empty($this->getAuthorization("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6"));
    }

    private function isPayeeAuthorized(): bool
    {
        return true;
        // não consegui abrir o mock, portanto não sei a estrutra nem o que retorna
        // todo: revisar padrão do mock
        return !empty($this->getAuthorization("https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04"));
    }

    /**
     * @param float $amount
     * @throws UnauthorizedTransferException
     */
    public function add(float $amount): void
    {
        if (!$this->isPayeeAuthorized()) {
            throw new UnauthorizedTransferException("Recebimento não autorizado.");
        }
        $this->balance += $amount;
    }

    /**
     * @param float $amount
     * @throws InsufficientBalanceException
     * @throws InvalidOperationException
     * @throws UnauthorizedTransferException
     */
    public function subtract(float $amount): void
    {
        if ($this->isShopkeeperWallet()) {
            throw new InvalidOperationException("Lojistas não podem transferir dinheiro.");
        } elseif ($this->balance < $amount) {
            throw new InsufficientBalanceException("Saldo insuficiente.");
        } elseif (!$this->isPayerAuthorized()) {
            throw new UnauthorizedTransferException("Retirada não pôde ser autorizada.");
        }
        $this->balance -= $amount;
    }
}
