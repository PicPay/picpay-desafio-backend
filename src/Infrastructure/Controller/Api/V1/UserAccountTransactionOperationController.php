<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Application\Command\UserAccount\TransactionOperationListCommand;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;
use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\Domain\UserAccount\DTO\TransactionOperationDTO;
use App\Infrastructure\DTO\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class UserAccountTransactionOperationController extends ApiController
{
    public function handleList(string $uuid): JsonResponse
    {
        try {
            $transactionOperationListCommand = $this->get(TransactionOperationListCommand::class);
            $transactionOperationCollection = $transactionOperationListCommand->execute($uuid);
            $dtoCollection = new Collection();
            foreach ($transactionOperationCollection->get() as $transactionOperation) {
                $dtoCollection->addItem(
                    new TransactionOperationDTO($transactionOperation)
                );
            }

            return $this->responseOk($dtoCollection->toArray());
        } catch (AccountNotFoundException $e) {
            return $this->responseNotFound([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
