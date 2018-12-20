<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Event\Event;

final class WithdrawalPerformed implements Event
{
    private $accountId;
    private $amount;

    public function __construct(string $accountId, int $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
