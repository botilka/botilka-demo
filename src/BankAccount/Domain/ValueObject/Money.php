<?php

declare(strict_types=1);

namespace App\BankAccount\Domain\ValueObject;

final class Money
{
    private $amount;
    private $currency;

    public function __construct(int $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
