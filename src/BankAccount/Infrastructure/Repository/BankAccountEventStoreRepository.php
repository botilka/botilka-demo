<?php

declare(strict_types=1);

namespace App\BankAccount\Infrastructure\Repository;

use App\BankAccount\Domain\BankAccount;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\EventStore\EventStore;
use Botilka\Repository\EventSourcedRepository;

final class BankAccountEventStoreRepository implements BankAccountRepository
{
    private $repository;

    public function __construct(EventSourcedRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(string $id): BankAccount
    {
        /** @var BankAccount $instance */
        $instance = $this->repository->load($id);

        return $instance;
    }
}
