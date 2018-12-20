<?php

declare(strict_types=1);

namespace App\BankAccount\Infrastructure\Doctrine;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class, properties={"currency": "exact"})
 * @ApiFilter(RangeFilter::class, properties={"balance"})
 * @ORM\Entity(
 *     readOnly=true
 * )
 */
class BankAccount
{
    /**
     * @ORM\Id @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance;

    public function __construct(string $id, string $name, string $currency, int $balance)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
        $this->currency = $currency;
        $this->balance = $balance;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
