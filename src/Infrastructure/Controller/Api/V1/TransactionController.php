<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Application\Command\Transaction\MoneyTransfer\ListCommand;
use App\Application\Command\Transaction\MoneyTransferCommand;
use App\Infrastructure\Controller\Api\ApiController;
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

            $moneyTransferCommand = $this->get(MoneyTransferCommand::class);
            $response = $moneyTransferCommand->execute($requestData);

            return $this->responseOk($response);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }

    public function handleList(): JsonResponse
    {
        try {
            $listCommand = $this->get(ListCommand::class);
            $transactionCollection = $listCommand->execute();
            return $this->responseOk(['aa' => 'ererer']);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
