<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use Botilka\Application\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateBankAccountCommand implements Command
{
    private $name;
    /**
     * @Assert\Length(min=3, max=3)
     */
    private $currency;

    public function __construct(string $name, ?string $currency)
    {
        $this->name = $name;
        $this->currency = $currency;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
