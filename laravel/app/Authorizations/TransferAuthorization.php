<?php

namespace App\Authorizations;

use App\Concepts\Authorization;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidOperationException;
use App\Models\Wallet;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TransferAuthorization implements Authorization
{

    /**
     * TransferAuthorization constructor.
     * @param Wallet $wallet
     * @param float $amount
     * @throws InvalidOperationException
     * @throws InsufficientBalanceException
     */
    public function __construct(Wallet $wallet, float $amount)
    {
        if ($wallet->isShopkeeperWallet()) {
            throw new InvalidOperationException("Lojistas não podem transferir dinheiro.");
        } elseif ($wallet->balance < $amount) {
            throw new InsufficientBalanceException("Saldo insuficiente.");
        }
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getAuthorizationResponse(): ResponseInterface
    {
        // não consegui abrir o mock, portanto não sei a estrutra nem o que retorna
        // todo: revisar padrão do mock
        $client = new Client();
        return $client->request(
            'GET',
            "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6",
            ['verify' => base_path('cacert.pem')]
        );
    }
}
