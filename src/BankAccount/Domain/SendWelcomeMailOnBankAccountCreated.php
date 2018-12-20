<?php

declare(strict_types=1);

namespace App\BankAccount\Domain;

use Botilka\Event\EventHandler;
use Psr\Log\LoggerInterface;

final class SendWelcomeMailOnBankAccountCreated implements EventHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(BankAccountCreated $event): void
    {
        $this->logger->info(\sprintf('%s "%s".', \get_class($this), $event->getName()));
    }
}
