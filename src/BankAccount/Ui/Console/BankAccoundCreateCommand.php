<?php

declare(strict_types=1);

namespace App\BankAccount\Ui\Console;

use App\BankAccount\Application\Command\CreateBankAccountCommand;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\Application\Command\CommandBus;
use Botilka\Application\Command\CommandResponse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BankAccoundCreateCommand extends Command
{
    private $commandBus;
    private $repository;

    public function __construct(CommandBus $commandBus, BankAccountRepository $repository)
    {
        parent::__construct(null);
        $this->commandBus = $commandBus;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('ba:create')
            ->setDescription('Create few bank accounts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            new CreateBankAccountCommand('account in $', 'DOL'),
            new CreateBankAccountCommand('account in €', 'EUR'),
            new CreateBankAccountCommand('account in £', 'GBP'),
        ];

        /** @var CommandResponse $commandResponse */
        $commandResponse = null;
        /** @var CreateBankAccountCommand $command */
        foreach ($commands as $command) {
            $commandResponse = $this->commandBus->dispatch($command);
            dump(\sprintf('%s: %s', $command->getCurrency(), $commandResponse->getId()));
        }
    }
}
