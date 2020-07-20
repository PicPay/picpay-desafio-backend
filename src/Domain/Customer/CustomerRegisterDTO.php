<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

/**
 * Class CustomerDTO
 * @package Transfer\Domain\Customer
 */
final class CustomerRegisterDTO
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $personType;

    /**
     * @var string
     */
    private string $document;

    /**
     * @var string|null
     */
    private ?string $password;

    /**
     * CustomerDTO constructor.
     * @param string $name
     * @param string $email
     * @param string $personType
     * @param string $document
     * @param string|null $password
     */
    public function __construct(string $name, string $email, string $personType, string $document, ?string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->personType = $personType;
        $this->document = $document;
        $this->password = hash('sha256', $password);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPersonType(): string
    {
        return $this->personType;
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'personType' => $this->getPersonType(),
            'document' => $this->getDocument()
        ];
    }
}
