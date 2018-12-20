<?php

declare(strict_types=1);

namespace App\Tests\BankAccount\Application\Command;

use App\BankAccount\Application\Command\PerformDepositCommand;
use PHPUnit\Framework\TestCase;

final class PerformDepositCommandTest extends TestCase
{
    /** @var PerformDepositCommand */
    private $command;

    public function setUp()
    {
        $this->command = new PerformDepositCommand('12345678-1234-1234-1234-123456789012', 123, 'foo');
    }

    public function testGetAmount()
    {
        $this->assertSame(123.0, $this->command->getAmount());
    }

    public function testGetAccountId()
    {
        $this->assertSame('12345678-1234-1234-1234-123456789012', $this->command->getAccountId());
    }

    public function testGetReason()
    {
        $this->assertSame('foo', $this->command->getReason());
    }
}
