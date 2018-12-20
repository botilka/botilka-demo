<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

interface BankAccountRepository
{
    public function get(string $id): BankAccount;
}
