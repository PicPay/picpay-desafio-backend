<?php

declare(strict_types=1);

$customErrorHandler = function (
    \Slim\Psr7\Request $request,
    Throwable $exception
) use ($app) {

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse(400);
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );


    return $response;
};
