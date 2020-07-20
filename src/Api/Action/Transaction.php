<?php

declare(strict_types=1);

namespace Transfer\Api\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Transfer\Domain\Transaction\TransactionDTO;
use Transfer\Domain\Transaction\TransactionService;

/**
 * Class Transaction
 * @package Transfer\Api\Action
 */
final class Transaction
{
    /**
     * @var TransactionService
     */
    private TransactionService $service;

    /**
     * Transaction constructor.
     * @param TransactionService $service
     */
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = json_decode($request->getBody()->getContents(), true);
        $this->validatePayload($payload);
        $this->service->create(new TransactionDTO(
            $payload['payer'],
            $payload['payee'],
            $payload['value']
        ));
        return $response->withStatus(201);
    }

    /**
     * @param $payload
     * @throws \Exception
     */
    private function validatePayload($payload)
    {
        if (!isset($payload['payer']) || !isset($payload['payee']) || !isset($payload['value'])) {
            throw new \Exception('Todos campos obrigatorios devem ser informados!');
        }

        if (!is_int($payload) && !is_int($payload['payee'])) {
            throw new \Exception('ID do customer deve ser um inteiro');
        }

        if (!is_float($payload['value'])) {
            throw new \Exception('Valor deve ser do tipo float');
        }
    }
}

