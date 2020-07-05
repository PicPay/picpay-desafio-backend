<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Application\Command\UserAccount\CreateCommand;
use App\Domain\UserAccount\Exception\Service\CreateService\AccountFoundException;
use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\Validator\UserAccountRegisterValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class UserAccountController extends ApiController
{
    public function handleCreate(Request $request): JsonResponse
    {
        $validator = new UserAccountRegisterValidator($request);

        if ($validator->hasErrors()) {
            return $this->responseBadRequest($validator->getErrors());
        }

        try {
            $requestData = $request
                ->request
                ->all();

            $createCommand = $this->get(CreateCommand::class);
            $account = $createCommand->execute($requestData);

            return $this->responseCreated(['time' => time()]);
        } catch (AccountFoundException $e) {
            return $this->responseUnprocessableEntity([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
