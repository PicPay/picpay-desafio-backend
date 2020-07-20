<?php

declare(strict_types=1);

namespace Transfer\Api\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Transfer\Domain\Customer\CustomerRegisterDTO;
use Transfer\Domain\Customer\CustomerService;

/**
 * Class RegisterCustomer
 * @package Transfer\Api\Action
 */
final class RegisterCustomer
{
    /**
     * @var CustomerService
     */
    private CustomerService $service;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;


    /**
     * RegisterUser constructor.
     * @param CustomerService $service
     * @param LoggerInterface $logger
     */
    public function __construct(CustomerService $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
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

        $customer = new CustomerRegisterDTO(
            $payload['name'],
            $payload['email'],
            $payload['personType'],
            $payload['document'],
            $payload['password']
        );

        $this->service->register($customer);
        return $response->withStatus(201);
    }
}
