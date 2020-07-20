<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

/**
 * Class CustomerDTO
 * @package Transfer\Domain\Customer
 */
final class CustomerDTO
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
     * CustomerDTO constructor.
     * @param string $name
     * @param string $email
     * @param string $personType
     * @param string $document
     */
    public function __construct(string $name, string $email, string $personType, string $document)
    {
        $this->name = $name;
        $this->email = $email;
        $this->personType = $personType;
        $this->document = $document;
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
