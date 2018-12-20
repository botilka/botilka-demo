<?php

declare(strict_types=1);

namespace App\BankAccount\Ui\Console;

use App\BankAccount\Application\Command\CreateBankAccountCommand;
use App\BankAccount\Application\Command\PerformDepositCommand;
use App\BankAccount\Application\Command\PerformWithdrawalCommand;
use Botilka\Application\Command\CommandBus;
use Botilka\EventStore\EventStore;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BankAccountTestCommand extends Command
{
    private $store;
    private $commandBus;

    public function __construct(EventStore $store, CommandBus $commandBus)
    {
        parent::__construct(null);
        $this->store = $store;
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this->setName('ba:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new CreateBankAccountCommand('account in $', 'DOL');
        $commandResponse = $this->commandBus->dispatch($command);

        $accountId = $commandResponse->getId();

        for ($i = 0; $i < 1000; ++$i) {
            $command = new PerformDepositCommand($accountId, \rand(0, 1000), null);
            $this->commandBus->dispatch($command);

            $command = new PerformWithdrawalCommand($accountId, \rand(0, 1000));
            $this->commandBus->dispatch($command);

            $output->writeln((string) $i);
        }
    }
}
