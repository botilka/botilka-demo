<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use App\BankAccount\Domain\BankAccount;
use Botilka\Application\Command\CommandHandler;
use Botilka\Application\Command\CommandResponse;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\Application\Command\EventSourcedCommandResponse;

final class PerformDepositHandler implements CommandHandler
{
    private $repository;

    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(PerformDepositCommand $command): CommandResponse
    {
        $bankAccount = $this->repository->get($command->getAccountId());
        /** @var BankAccount $instance */
        [$instance, $event] = $bankAccount->deposit($command->getAmount());

        return EventSourcedCommandResponse::fromEventSourcedAggregateRoot($instance, $event);
    }
}
