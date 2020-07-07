<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Application\Command\Transaction\MoneyTransfer\ListCommand;
use App\Application\Command\Transaction\MoneyTransfer\TransferCommand;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransferService\AccountNotFoundException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransferService\InsufficientBalanceException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\Validator\ExternalValidatorValidationException;
use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\Domain\Transaction\DTO\TransactionDTO;
use App\Infrastructure\DTO\Collection;
use App\Infrastructure\Validator\TransactionValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class TransactionController extends ApiController
{
    public function handleTransaction(Request $request): JsonResponse
    {
        try {
            $validator = new TransactionValidator($request);

            if ($validator->hasErrors()) {
                return $this->responseBadRequest($validator->getErrors());
            }

            $requestData = $request
                ->request
                ->all()
            ;

            $transferCommand = $this->get(TransferCommand::class);
            $transaction = $transferCommand->execute($requestData);
            $transactionDTO = new TransactionDTO($transaction);

            return $this->responseCreated($transactionDTO->toArray());

        } catch (AccountNotFoundException|InsufficientBalanceException|ExternalValidatorValidationException $e) {
            return $this->responsePreconditionFailed([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }

    public function handleList(): JsonResponse
    {
        try {
            $listCommand = $this->get(ListCommand::class);
            $transactionCollection = $listCommand->execute();
            $dtoCollection = new Collection();
            foreach ($transactionCollection->get() as $transaction) {
                $dtoCollection->addItem(
                    new TransactionDTO($transaction)
                );
            }

            return $this->responseOk($dtoCollection->toArray());
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
