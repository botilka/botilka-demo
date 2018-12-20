<?php

declare(strict_types=1);

namespace App\BankAccount\Application\Query;

use Botilka\Application\Query\QueryHandler;
use Doctrine\ORM\EntityManagerInterface;

final class FindBankAccountByCurrencyHandler implements QueryHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(FindBankAccountByCurrencyQuery $query): array
    {
        $dqlQuery = $this->entityManager->createQuery(
            'SELECT NEW App\BankAccount\Application\Query\ViewModel\BankAccountViewModel(b.id, b.name, b.currency, b.balance) FROM App\BankAccount\Infrastructure\Doctrine\BankAccount b WHERE b.currency = :currency'
        );

        $dqlQuery->setParameter(':currency', $query->getCurrency());

        return $dqlQuery->getResult();
    }
}
