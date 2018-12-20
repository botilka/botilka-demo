<?php

declare(strict_types=1);

namespace App\Tests\BankAccount\Application\Command;

use App\BankAccount\Application\Command\CreateBankAccountCommand;
use PHPUnit\Framework\TestCase;

final class CreateBankAccountCommandTest extends TestCase
{
    /** @var CreateBankAccountCommand */
    private $command;

    public function setUp()
    {
        $this->command = new CreateBankAccountCommand('foo', 'BAR');
    }

    public function testGetName()
    {
        $this->assertSame('foo', $this->command->getName());
    }

    public function testGetCurrency()
    {
        $this->assertSame('BAR', $this->command->getCurrency());
    }
}
