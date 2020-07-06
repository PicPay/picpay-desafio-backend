<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\ORM\Entity\Operation;
use App\Infrastructure\ORM\Entity\Transaction;
use App\Infrastructure\ORM\Repository\AccountRepository;
use App\Infrastructure\ORM\Repository\OperationRepository;
use App\Infrastructure\ORM\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TransactionController extends ApiController
{
    public function handleTransaction(Request $request): JsonResponse
    {
        $accountRepository = $this->get(AccountRepository::class);
        $operationRepository = $this->get(OperationRepository::class);
        $transactionRepository = $this->get(TransactionRepository::class);

//        $payerAccount = $accountRepository->findOneBy(['uuid' => 'c04197db-01c8-480e-91d1-6f572564ecad']);
//        $payeeAccount = $accountRepository->findOneBy(['uuid' => '32a2f7e4-d86b-49ee-81b2-1f95914947d8']);
//
//        $transaction = new Transaction();
//        $transaction->setPayer($payerAccount);
//        $transaction->setPayee($payeeAccount);
//        $transaction->setAuthentication('AAAAAAAAABBBBBBBBB');
//        $transaction->setAmount(1250);
//
//        $transaction = $transactionRepository->add($transaction);
//
//        $operationPayer = new Operation();
//        $operationPayer->setTransaction($transaction);
//        $operationPayer->setAccount($payerAccount);
//        $operationPayer->setType('out');
//
//        $operationRepository->add($operationPayer);
//
//        $operationPayee = new Operation();
//        $operationPayee->setTransaction($transaction);
//        $operationPayee->setAccount($payeeAccount);
//        $operationPayee->setType('in');
//
//        $operationRepository->add($operationPayee);

        $uuid = 'c04197db-01c8-480e-91d1-6f572564ecad';

        $a = $operationRepository->testBla($uuid);
        dd($a);

        return $this->responseOk(['aa' => 'bb']);
    }
}
