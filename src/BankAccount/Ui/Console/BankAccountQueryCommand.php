<?php

declare(strict_types=1);

namespace App\BankAccount\Ui\Console;

use App\BankAccount\Domain\BankAccountRepository;
use App\BankAccount\Application\Query\FindBankAccountByCurrencyQuery;
use Botilka\Application\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BankAccountQueryCommand extends Command
{
    private $queryBus;
    private $repository;

    public function __construct(QueryBus $queryBus, BankAccountRepository $repository)
    {
        parent::__construct(null);
        $this->queryBus = $queryBus;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('ba:query:currency')
            ->setDescription('Query bank accounts by it\'s currency')
            ->addArgument('currency', InputArgument::REQUIRED, 'Currency to find');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $currency */
        $currency = $input->getArgument('currency');
        $query = new FindBankAccountByCurrencyQuery($currency);
        $result = $this->queryBus->dispatch($query);

        dump($result);
    }
}
