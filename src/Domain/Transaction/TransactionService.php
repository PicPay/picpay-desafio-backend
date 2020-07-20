<?php

declare(strict_types=1);

namespace Transfer\Domain\Transaction;

use Exception;
use Psr\Log\LoggerInterface;
use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerInterface;
use Transfer\Domain\Customer\CustomerListDTO;
use Transfer\Infra\Http\TransferAuthorizeAdapter;
use Transfer\Infra\Http\TransferNotificationAdapter;
use Transfer\Infra\QueueAdapter;

/**
 * Class TransactionService
 * @package Transfer\Domain\Transaction
 */
final class TransactionService
{
    /**
     * @var TransactionDAOInterface
     */
    private TransactionDAOInterface $transactionDAO;

    /**
     * @var CustomerInterface
     */
    private CustomerInterface $customerService;

    /**
     * @var TransferAuthorizeAdapter
     */
    private TransferAuthorizeAdapter $transferAuthorizeAdapter;

    /**
     * @var TransferNotificationAdapter
     */
    private TransferNotificationAdapter $transferNotificationAdapter;

    /**
     * @var QueueAdapter
     */
    private QueueAdapter $queueAdapter;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var array
     */
    private array $customers = array();

    /**
     * TransactionService constructor.
     * @param TransactionDAOInterface $transactionDAO
     * @param CustomerInterface $customerService
     * @param TransferAuthorizeAdapter $transferAuthorizeAdapter
     * @param TransferNotificationAdapter $transferNotificationAdapter
     * @param QueueAdapter $queueAdapter
     * @param LoggerInterface $logger
     */
    public function __construct(
        TransactionDAOInterface $transactionDAO,
        CustomerInterface $customerService,
        TransferAuthorizeAdapter $transferAuthorizeAdapter,
        TransferNotificationAdapter $transferNotificationAdapter,
        QueueAdapter $queueAdapter,
        LoggerInterface $logger

    ) {
        $this->transactionDAO = $transactionDAO;
        $this->customerService = $customerService;
        $this->transferAuthorizeAdapter = $transferAuthorizeAdapter;
        $this->transferNotificationAdapter = $transferNotificationAdapter;
        $this->queueAdapter = $queueAdapter;
        $this->logger = $logger;
    }

    /**
     * @param TransactionDTO $transactionDTO
     * @throws \Exception
     */
    public function create(TransactionDTO $transactionDTO): void
    {
        try {

            $this->getCustomers($transactionDTO);

            $this->verifyTransfer($transactionDTO);

            $this->transactionDAO->getDatabase()->beginTransaction();

            $this->transactionDAO->create($transactionDTO);

            $this->updateCustomerBalance($transactionDTO->getValue());

            $this->transactionDAO->getDatabase()->commit();

            $this->sendNotification();

        } catch (\Exception $e) {
            $this->transactionDAO->getDatabase()->rollBack();

            $log = [
                'data' => [
                    'transaction' => $transactionDTO->toArray(),
                ],
                'key' => 'transaction_create_exception',
                'message' => 'Não foi possivel realizar a transacao',
                'exception' => $e->getMessage(),
                'class' => __CLASS__,
                'method' => __METHOD__
            ];
            $this->log($log);

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param TransactionDTO $transactionDTO
     * @throws \Exception
     */
    private function getCustomers(TransactionDTO $transactionDTO): void
    {
        $customerList = new CustomerListDTO();

        $customerList->add(
            $this->getCustomerById($transactionDTO->getPayerId()),
            $customerList::PAYER_TYPE
        );

        $customerList->add(
            $this->getCustomerById($transactionDTO->getPayeeId()),
            $customerList::PAYEE_TYPE
        );

        $this->customers = $customerList->getCustomerList();
    }

    /**
     * @param TransactionDTO $transactionDTO
     * @throws \Exception
     */
    private function verifyTransfer(TransactionDTO $transactionDTO): void
    {

        if (!$this->checkPayerFunds($transactionDTO->getValue())) {
            throw new \Exception('O pagador nao possui saldo suficiente para realizar esta transferencia');
        }

        if (!$this->checkPayeePersonType()) {
            throw new \Exception('Apenas contas de pessoa física podem realizar transferencias');
        }

        if (!$this->isTransferAuthorized()) {
            throw new \Exception('A transferencia nao foi autorizada!');
        }
    }

    /**
     * @param int $id
     * @return CustomerBalanceDTO
     * @throws \Exception
     */
    private function getCustomerById(int $id): CustomerBalanceDTO
    {
        return $this->customerService->findById($id);
    }

    /**
     * @param float $value
     * @return bool
     */
    private function checkPayerFunds(float $value): bool
    {
        return $this->customers['payer']->getBalance() > $value;
    }

    /**
     * @return bool
     */
    private function checkPayeePersonType(): bool
    {
        return $this->customers['payer']->getCustomer()->getPersonType() === 'PF';
    }

    /**
     * @return bool
     */
    private function isTransferAuthorized(): bool
    {
        return $this->transferAuthorizeAdapter->request()->isResponseOk();
    }

    /**
     * @param float $value
     */
    private function updateCustomerBalance(float $value): void
    {
        $this->customerService->updateCustomerBalanceById($this->customers, $value);
    }

    private function sendNotification()
    {
        if (!$this->transferNotificationAdapter->request()->isResponseOk()) {
            $this->addRetryMessageToQueue([]);
        }
    }

    /**
     * @param $payload
     */
    private function addRetryMessageToQueue(array $payload): void
    {
        $this->queueAdapter->publish($payload);
    }

    /**
     * @param array $data
     * @param string $type
     */
    private function log(array $data, string $type = 'INFO'): void
    {
        $this->logger->log($type, json_encode($data));
    }
}

