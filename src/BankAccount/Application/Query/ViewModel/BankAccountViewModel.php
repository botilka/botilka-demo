<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Query\ViewModel;

final class BankAccountViewModel
{
    private $id;
    private $name;
    private $currency;
    private $balance;

    public function __construct(string $id, string $name, string $currency, int $balance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
        $this->balance = $balance;
    }

    public function getId(): string
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

    public function __toString()
    {
        return \sprintf('[BankAccountViewModel] name: %s, currency: %s, balance: %d', $this->getName(), $this->getCurrency(), $this->getBalance());
    }
}
