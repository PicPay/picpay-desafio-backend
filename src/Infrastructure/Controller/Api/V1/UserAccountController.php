<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Application\Command\UserAccount\CreateCommand;
use App\Application\Command\UserAccount\GetCommand;
use App\Application\Command\UserAccount\ListCommand;
use App\Domain\UserAccount\Exception\Service\CreateService\AccountFoundException;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;
use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\Domain\UserAccount\DTO\AccountDTO;
use App\Infrastructure\DTO\Collection;
use App\Infrastructure\Validator\UserAccountRegisterValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class UserAccountController extends ApiController
{
    public function handleCreate(Request $request): JsonResponse
    {
        try {
            $validator = new UserAccountRegisterValidator($request);

            if ($validator->hasErrors()) {
                return $this->responseBadRequest($validator->getErrors());
            }

            $requestData = $request
                ->request
                ->all()
            ;

            $createCommand = $this->get(CreateCommand::class);
            $account = $createCommand->execute($requestData);
            $accountDTO = new AccountDTO($account);

            return $this->responseCreated($accountDTO->toArray());
        } catch (AccountFoundException $e) {
            return $this->responseUnprocessableEntity([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }

    public function handleList(): JsonResponse
    {
        try {
            $listCommand = $this->get(ListCommand::class);
            $accountCollection = $listCommand->execute();
            $dtoCollection = new Collection();
            foreach ($accountCollection->get() as $account) {
                $dtoCollection->addItem(
                    new AccountDTO($account)
                );
            }

            return $this->responseOk($dtoCollection->toArray());
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }

    public function handleGet(string $uuid): JsonResponse
    {
        try {
            $getCommand = $this->get(GetCommand::class);
            $account = $getCommand->execute($uuid);
            $accountDTO = new AccountDTO($account);

            return $this->responseOk($accountDTO->toArray());
        } catch (AccountNotFoundException $e) {
            return $this->responseNotFound([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
