<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Command;

use App\BankAccount\Domain\BankAccount;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\Application\Command\CommandHandler;
use Botilka\Application\Command\CommandResponse;
use Botilka\Application\Command\EventSourcedCommandResponse;
use Ramsey\Uuid\Uuid;

final class CreateBankAccountHandler implements CommandHandler
{
    private $repository;

    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateBankAccountCommand $command): CommandResponse
    {
        $id = Uuid::uuid4();
        /** @var BankAccount $instance */
        [$instance, $event] = BankAccount::create($id->toString(), $command->getName(), $command->getCurrency());

        return EventSourcedCommandResponse::fromEventSourcedAggregateRoot($instance, $event);
    }
}
