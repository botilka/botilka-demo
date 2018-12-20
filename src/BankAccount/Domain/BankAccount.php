<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Domain\EventSourcedAggregateRoot;

/**
 * This class is event sourced.
 */
final class BankAccount implements EventSourcedAggregateRoot
{
    use BankAccountApplier;

    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $currency;
    /** @var int */
    private $balance;

    public static function create(string $id, string $name, string $currency): array
    {
        $instance = new self();
        $event = new BankAccountCreated($id, $name, $currency);

        return [
            $instance->apply($event),
            $event,
        ];
    }

    public function deposit(int $amount): array
    {
        $event = new DepositPerformed($this->id, $amount);

        return [
            $this->apply($event),
            $event,
        ];
    }

    public function withdraw(int $amount): array
    {
        $event = new WithdrawalPerformed($this->id, $amount);

        return [
            $this->apply($event),
            $event,
        ];
    }

    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}
