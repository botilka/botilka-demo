<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Event\EventHandler;
use Psr\Log\LoggerInterface;

final class LogOnDepositPerformed implements EventHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(DepositPerformed $event): void
    {
        $this->logger->info(\sprintf('%s account: %s - deposit: %d.', \get_class($this), $event->getAccountId(), $event->getAmount()));
    }
}
