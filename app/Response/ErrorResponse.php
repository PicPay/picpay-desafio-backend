<?php

namespace App\Response;

use Exception;
use Throwable;
use App\Exceptions\BaseExceptions;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorResponse extends Response
{
    protected $payload = [];

    protected $status = IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR;

    private $customStatusTexts = [
        IlluminateResponse::HTTP_BAD_REQUEST => 'BadRequestError',
        IlluminateResponse::HTTP_UNAUTHORIZED => 'UnauthorizedError',
        IlluminateResponse::HTTP_NOT_FOUND => 'NotFoundError',
        IlluminateResponse::HTTP_CONFLICT => 'ConflictError',
        IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR => 'InternalError',
    ];

    public function __construct(Throwable $exception)
    {
        $this->payload = [
            'code' => $this->getStatusText(IlluminateResponse::HTTP_BAD_REQUEST),
            'message' => (string) $exception->getMessage(),
            'errors' => [],
        ];

        if ($exception instanceof NotFoundHttpException) {
            $this->payload['code'] = $this->getStatusText($exception->getStatusCode());
            $this->status = $exception->getStatusCode();
            $this->payload['message'] = 'The endpoint you are looking for does not exist or has been deprecated';
        }
        if ($exception instanceof HttpException) {
            $this->payload['code'] = $this->getStatusText($exception->getStatusCode());
            $this->status = $exception->getStatusCode();
        } elseif ($exception instanceof ModelNotFoundException) {
            $this->payload['code'] = $this->getStatusText(IlluminateResponse::HTTP_NOT_FOUND);
            $this->status = IlluminateResponse::HTTP_NOT_FOUND;
        } elseif ($exception instanceof QueryException) {
            $this->payload['code'] = $this->getStatusText(IlluminateResponse::HTTP_CONFLICT);
            $this->status = IlluminateResponse::HTTP_CONFLICT;
            $this->payload['message'] = $this->sanitizeMySQLConflictError($exception->getMessage());
        } elseif ($exception instanceof ValidationException) {
            $this->payload['code'] = $this->getStatusText(IlluminateResponse::HTTP_BAD_REQUEST);
            $this->payload['errors'] = $exception->validator->errors();
            $this->status = IlluminateResponse::HTTP_BAD_REQUEST;
            $this->payload['message'] = 'One or more fields are invalid';
        } elseif (is_subclass_of($exception, BaseExceptions::class)) {
            $this->payload['code'] = $exception->getCode();
            $this->status = $exception->getCode();
            $this->payload['message'] = $exception->getMessage();
        } elseif ($exception instanceof AuthenticationException) {
            $this->payload['code'] = $this->getStatusText(IlluminateResponse::HTTP_UNAUTHORIZED);
            $this->status = IlluminateResponse::HTTP_UNAUTHORIZED;
            $this->payload['message'] = '[auth] Invalid user or password';
        }

        if (env('APP_DEBUG')) {
            $this->payload['debug'] = [
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
                'trace' => $exception->getTraceAsString(),
            ];
        }
    }

    private function getStatusText(int $code): string
    {
        $statusTexts = $this->customStatusTexts + IlluminateResponse::$statusTexts;

        return $statusTexts[$code] ?? null;
    }

    private function sanitizeMySQLConflictError(string $error): string
    {
        try {
            preg_match('/SQLSTATE\[[0-9]+\]: ([a-zA-Z0-9\s:\'-_]+) \(.*/', $error, $matches);

            return $matches[1];
        } catch (Exception $e) {
            return 'Integrity constraint violation';
        }
    }
}
