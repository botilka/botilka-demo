<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Event\Event;

final class BankAccountCreated implements Event
{
    private $id;
    private $name;
    private $currency;

    public function __construct(string $id, string $name, string $currency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
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
}
