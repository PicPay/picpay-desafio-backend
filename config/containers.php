<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;
use Transfer\Domain\Customer\CustomerDAOInterface;
use Transfer\Domain\Customer\CustomerService;
use Transfer\Domain\Transaction\TransactionDAOInterface;
use Transfer\Domain\Transaction\TransactionService;
use Transfer\Infra\DAO\Customer\CustomerDAO;
use Transfer\Infra\DAO\Transaction\TransactionDAO;
use Transfer\Infra\Database\Database;
use Transfer\Infra\Database\DatabaseAdapter;
use Transfer\Infra\Http\Adapter;
use Transfer\Infra\Http\Client;
use Transfer\Infra\Http\Http;
use Transfer\Infra\Http\TransferAuthorizeAdapter;
use Transfer\Infra\Http\TransferNotificationAdapter;
use Transfer\Infra\QueueAdapter;

$builder  = new \DI\ContainerBuilder();
$container = $builder->build();


$container->set(LoggerInterface::class, function ()  {
   return new \Monolog\Logger('transfer-log', [
       new \Monolog\Handler\StreamHandler('app.log', \Monolog\Logger::INFO),
    ]);
});

$db = [
    'driver' => 'pdo_mysql',
    'charset' => getenv('DB_CHARSET'),
    'host' => '172.19.0.1',
    'port' => getenv('DB_PORT'),
    'dbname' => 'transfer',
    'user' => 'root',
    'pass' => 'root'
];

$container->set(Database::class, function () {
    return new DatabaseAdapter(
        DriverManager::getConnection([
            'charset'  => 'utf8',
            'driver'   => 'pdo_mysql',
            'host'     => '172.19.0.1',
            'port'     => getenv('DB_PORT'),
            'dbname'   => 'transfer',
            'user'     => 'root',
            'password' => 'root'
        ])
    );
});


$container->set(Http::class, function () {
    return new Client(new GuzzleClient([
        'http_errors'       => false,
        'verify'            => false,
        'timeout'           => 10,
        'connect_timeout'   => 30
    ]));
});

$container->set(CustomerDAOInterface::class, function (\DI\Container $container) {
   return new CustomerDAO($container->get(Database::class));
});

$container->set(TransactionDAOInterface::class, function (\DI\Container $container) {
    return new TransactionDAO($container->get(Database::class));
});

$container->set(TransferAuthorizeAdapter::class, function (\DI\Container $container) {
    return new TransferAuthorizeAdapter(
        $container->get(Adapter::class),
        getenv('TRANSFER_AUTHORIZE_URL')
    );
});

$container->set(TransferNotificationAdapter::class, function (\DI\Container $container) {
    return new TransferNotificationAdapter(
        $container->get(Adapter::class),
        getenv('TRANSFER_NOTIFICATION_URL')
    );
});

$container->set(TransactionService::class, function(\DI\Container $container) {
    return new TransactionService(
        $container->get(TransactionDAO::class),
        $container->get(CustomerService::class),
        $container->get(TransferAuthorizeAdapter::class),
        $container->get(TransferNotificationAdapter::class),
        $container->get(QueueAdapter::class),
        $container->get(LoggerInterface::class)
    );
});
