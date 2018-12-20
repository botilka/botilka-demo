<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use Botilka\Application\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

final class PerformDepositCommand implements Command
{
    private $accountId;

    /**
     * @Assert\GreaterThan(500)
     */
    private $amount;
    private $reason;

    public function __construct(string $accountId, float $amount, ?string $reason)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->reason = $reason;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
