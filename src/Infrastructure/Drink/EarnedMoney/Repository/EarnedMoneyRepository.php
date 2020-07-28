<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Repository;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;
use Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository\EarnedMoneyInterface;
use Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query\GetQuery;
use Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query\StoreQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;

final class EarnedMoneyRepository extends ServiceEntityRepository implements EarnedMoneyInterface
{
    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EarnedMoney::class);

        $this->em = $registry->getManager();
    }

    public function store(OrderDrink $orderDrink): void
    {
        $getQuery = new GetQuery($this->em);

        $earnedMoneyEntity = $getQuery->getByName($orderDrink->name());

        if (is_null($earnedMoneyEntity)) {
            $earnedMoneyEntity = new EarnedMoney();

            $earnedMoneyEntity->setDrink($orderDrink->name());
            $earnedMoneyEntity->setProfit($orderDrink->money());
        }

        // Update profit if drink already exist
        $earnedMoneyEntity->setProfit($getQuery->sumProfit($orderDrink->name(), $orderDrink->money()));

        (new StoreQuery($this->em))->storeProfit($earnedMoneyEntity);
    }
}
