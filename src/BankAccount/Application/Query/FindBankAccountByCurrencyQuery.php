<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Query;

use Botilka\Application\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;

final class FindBankAccountByCurrencyQuery implements Query
{
    /**
     * @Assert\Length(min=2, max=4)
     */
    private $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
