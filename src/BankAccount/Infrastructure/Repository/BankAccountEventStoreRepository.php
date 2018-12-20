<?php

declare(strict_types=1);

namespace App\BankAccount\Infrastructure\Repository;

use App\BankAccount\Domain\BankAccount;
use App\BankAccount\Domain\BankAccountRepository;
use Botilka\EventStore\EventStore;

final class BankAccountEventStoreRepository implements BankAccountRepository
{
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(string $id): BankAccount
    {
        $events = $this->eventStore->load($id);
        $instance = new BankAccount();

        foreach ($events as $event) {
            /** @var BankAccount $instance */
            $instance = $instance->apply($event);
        }

        return $instance;
    }
}
