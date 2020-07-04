<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Document;

abstract class AbstractDocument implements DocumentInterface
{
    public const TYPE_CPF = 'cpf';
    public const TYPE_CNPJ = 'cnpj';

    private string $number;
    private string $type;

    public function getNumber(): string
    {
        return $this->number;
    }

    protected function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function setTypeCpf(): void
    {
        $this->type = self::TYPE_CPF;
    }

    protected function setTypeCnpj(): void
    {
        $this->type = self::TYPE_CNPJ;
    }

    public function isTypeCpf(): bool
    {
        return self::TYPE_CPF === $this->getType();
    }

    public function isTypeCnpj(): bool
    {
        return self::TYPE_CNPJ === $this->getType();
    }
}
