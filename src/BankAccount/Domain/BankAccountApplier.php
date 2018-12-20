<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Domain\EventSourcedAggregateRootApplier;

trait BankAccountApplier
{
    use EventSourcedAggregateRootApplier;

    protected $eventMap = [
        BankAccountCreated::class => 'bankAccountCreated',
        DepositPerformed::class => 'depositPerformed',
        WithdrawalPerformed::class => 'withdrawalPerformed',
    ];

    private function bankAccountCreated(BankAccountCreated $event): BankAccount
    {
        $instance = clone $this;

        $instance->id = $event->getId();
        $instance->name = $event->getName();
        $instance->currency = $event->getCurrency();
        $instance->balance = 0;

        return $instance;
    }

    private function depositPerformed(DepositPerformed $event): BankAccount
    {
        $instance = clone $this;

        $instance->balance += $event->getAmount();

        return $instance;
    }

    private function withdrawalPerformed(WithdrawalPerformed $event): BankAccount
    {
        $instance = clone $this;

        $instance->balance -= $event->getAmount();

        return $instance;
    }
}
