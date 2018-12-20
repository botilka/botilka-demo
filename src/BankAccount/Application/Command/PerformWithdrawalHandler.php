<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use App\BankAccount\Domain\BankAccount;
use Botilka\Application\Command\CommandHandler;
use Botilka\Application\Command\CommandResponse;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\Application\Command\EventSourcedCommandResponse;

final class PerformWithdrawalHandler implements CommandHandler
{
    private $repository;

    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(PerformWithdrawalCommand $command): CommandResponse
    {
        $bankAccount = $this->repository->get($command->getAccountId());
        /** @var BankAccount $instance */
        [$instance, $event] = $bankAccount->withdraw($command->getAmount());

        return EventSourcedCommandResponse::fromEventSourcedAggregateRoot($instance, $event);
    }
}
