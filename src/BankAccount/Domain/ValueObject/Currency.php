<?php

declare(strict_types=1);

namespace App\BankAccount\Domain\ValueObject;

final class Currency
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): int
    {
        return $this->name;
    }
}
