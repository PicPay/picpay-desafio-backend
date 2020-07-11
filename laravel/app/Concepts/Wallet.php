<?php

namespace App\Concepts;

use App\Enums\WalletTypeEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidPersonTypeException;
use App\Exceptions\InvalidWalletTypeException;
use App\Exceptions\UnauthorizedTransferException;
use App\ShopkeeperWallet;
use App\UserWallet;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class Wallet extends Model
{
    protected $table = "wallets";
    protected $attributes = [
        "balance" => 0.0,
        "type" => WalletTypeEnum::SHOPKEEPER_WALLET,
    ];

    /**
     * @param float $value
     * @throws UnauthorizedTransferException
     * @throws Throwable
     */
    public function add(float $value): void
    {
        if (!$this->isAuthorizedToReceive()) {
            throw new UnauthorizedTransferException("Transferência não autorizada.");
        }
        $this->balance += $value;
        $this->saveOrFail();
    }

    /**
     * @param float $value
     * @throws InsufficientBalanceException
     * @throws UnauthorizedTransferException
     * @throws Throwable
     */
    public function subtract(float $value): void
    {
        if (!$this->hasBalance()) {
            throw new InsufficientBalanceException("Não há saldo suficiente para descontar $value.");
        } elseif (!$this->isAuthorizedToSend($value)) {
            throw new UnauthorizedTransferException("Transferência não autorizada.");
        }
        $this->balance -= $value;
        $this->saveOrFail();
    }

    public function hasBalance(float $valueToSubtract = 0.0): bool
    {
        return $this->balance - $valueToSubtract >= 0;
    }

    protected function getAuthorizationResult(string $method, string $url, array $options = []): ?array
    {
        $client = new GuzzleHttpClient();
        $response = $client->request($method, $url, $options);

        if ($response->getStatusCode() !== 200 || !($json = json_decode($response->getBody()))) {
            return null;
        }
        return $json;
    }

    public function isAuthorizedToReceive(): bool
    {
        $authorization = $this->getAuthorizationResult(
            "GET",
            "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6"
        );
        return boolval($authorization);
    }

    public function isAuthorizedToSend(): bool
    {
        $authorization = $this->getAuthorizationResult(
            "GET",
            "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04"
        );
        return boolval($authorization);
    }

    /**
     * @return Person|null
     * @throws InvalidPersonTypeException
     */
    public function person(): ?Person
    {
        return Person::getBelongedPerson($this);
    }

    /**
     * @return $this|null
     * @throws InvalidWalletTypeException
     */
    public function getRightBuild(): ?Wallet
    {
        if (!$this->type) {
            return null;
        } elseif (get_class($this) !== self::class) {
            return $this;
        }
        switch ($this->type) {
            case WalletTypeEnum::USER_WALLET:
                $userWallet = new UserWallet();
                $userWallet->setRawAttributes($this->getAttributes(), true);
                return $userWallet;
                break;
            case WalletTypeEnum::SHOPKEEPER_WALLET:
                $shopkeeperWallet = new ShopkeeperWallet();
                $shopkeeperWallet->setRawAttributes($this->getAttributes(), true);
                return $shopkeeperWallet;
                break;
        }
        throw new InvalidWalletTypeException("Tipo de carteira inválido.");
    }

    /**
     * @param Person $person
     * @return static|null
     * @throws InvalidWalletTypeException
     */
    public static function getPersonWallet(Person $person): ?self
    {
        $walletModel = $person->hasOne(self::class);
        if (!$walletModel->exists()) {
            return null;
        }
        /** @var self $wallet */
        $wallet = $walletModel->first();
        return $wallet->getRightBuild();
    }
}
