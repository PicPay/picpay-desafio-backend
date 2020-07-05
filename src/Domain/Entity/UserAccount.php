<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;

class UserAccount
{
    private string $name;
    private Document $document;
    private Email $email;
}
