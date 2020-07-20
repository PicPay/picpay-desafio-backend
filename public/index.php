<?php
require '../vendor/autoload.php';

require_once '../config/containers.php';


$app = \DI\Bridge\Slim\Bridge::create($container);

require_once '../config/routes.php';
require_once '../config/errorHandler.php';


$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->addRoutingMiddleware();
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();
