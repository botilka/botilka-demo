<?php

declare(strict_types=1);

namespace App\BankAccount\Projection\Doctrine;

use App\BankAccount\Domain\BankAccountCreated;
use App\BankAccount\Domain\DepositPerformed;
use App\BankAccount\Domain\WithdrawalPerformed;
use App\BankAccount\Infrastructure\Doctrine\BankAccount;
use Botilka\Projector\Projector;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;

final class BankAccountProjector implements Projector
{
    /** @var Connection */
    private $connection;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    public function onBankAccountCreated(BankAccountCreated $event): void
    {
        $id = $event->getId();
        // delete in case of replay
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare('DELETE FROM bank_account WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $entity = new BankAccount($id, $event->getName(), $event->getCurrency(), 0);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function onDepositPerformed(DepositPerformed $event): void
    {
        $stmt = $this->connection->prepare('UPDATE bank_account SET balance = balance + :amount WHERE id = :id');
        $stmt->execute(['id' => $event->getAccountId(), 'amount' => $event->getAmount()]);
    }

    public function onWithdrawalPerformed(WithdrawalPerformed $event): void
    {
        $stmt = $this->connection->prepare('UPDATE bank_account SET balance = balance - :amount WHERE id = :id');
        $stmt->execute(['id' => $event->getAccountId(), 'amount' => $event->getAmount()]);
    }

    public static function getSubscribedEvents()
    {
        return [
            BankAccountCreated::class => 'onBankAccountCreated',
            DepositPerformed::class => 'onDepositPerformed',
            WithdrawalPerformed::class => 'onWithdrawalPerformed',
        ];
    }
}
