<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use Botilka\Application\Command\Command;

final class PerformWithdrawalCommand implements Command
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
