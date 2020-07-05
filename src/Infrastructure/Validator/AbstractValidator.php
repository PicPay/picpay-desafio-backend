<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use Symfony\Component\HttpFoundation\Request;

use function count;
use function sprintf;

abstract class AbstractValidator implements ValidatorInterface
{
    protected Request $request;
    private array $errors;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->errors = [];
        $this->handleValidation();
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        if (!$this->hasErrors()) {
            return [];
        }

        return ['errors' => $this->errors];
    }

    protected function addError(string $param, string $message): void
    {
        $this->errors[] = sprintf('[ %s ] %s', $param, $message);
    }

    protected function addErrorParamRequired(string $param): void
    {
        $this->addError($param, 'param is required');
    }

    protected function hasValue(string $param): bool
    {
        return '$$$' !== $this
            ->request
            ->get($param, '$$$')
        ;
    }

    protected function getValue(string $param)
    {
        return $this
            ->request
            ->get($param)
        ;
    }

    abstract protected function handleValidation(): void;
}
