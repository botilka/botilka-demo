<?php

declare(strict_types=1);

namespace App\BankAccount\Ui\Console;

use App\BankAccount\Application\Command\PerformDepositCommand;
use App\BankAccount\Application\Command\PerformWithdrawalCommand;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\Application\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BankAccountUseCommand extends Command
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
        $this->setName('ba:use')
            ->setDescription('Perform deposit & withdraw on a bank account')
            ->addArgument('id', InputArgument::REQUIRED, 'Uuid of the bank account');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $id */
        $id = $input->getArgument('id');

        $command = new PerformDepositCommand($id, 20, 'paske');
        $this->commandBus->dispatch($command);

        $command = new PerformWithdrawalCommand($id, 50);
        $this->commandBus->dispatch($command);
        $bankAccount = $this->repository->get($id);
        dump($bankAccount->getBalance());
    }
}
