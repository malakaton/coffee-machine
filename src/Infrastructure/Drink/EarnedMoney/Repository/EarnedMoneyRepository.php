<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Repository;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;
use Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository\EarnedMoneyInterface;
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
        $earnedMoney = $this->getDrinkByName($orderDrink->name());

        if (is_null($earnedMoney)) {
            $earnedMoney = $this->create($orderDrink);
        } else {
            $earnedMoney = $this->updateProfit($earnedMoney, $orderDrink);
        }

        $this->em->persist($earnedMoney);

        $this->em->flush();
    }

    /**
     * @param OrderDrink $orderDrink
     * @return EarnedMoney
     */
    public function create(OrderDrink $orderDrink): EarnedMoney
    {
        $earnedMoney = new EarnedMoney();

        $earnedMoney->setDrink($orderDrink->name());
        $earnedMoney->setProfit($orderDrink->money());

        return $earnedMoney;
    }

    /**
     * @param EarnedMoney $earnedMoney
     * @param OrderDrink $orderDrink
     * @return EarnedMoney
     */
    public function updateProfit(EarnedMoney $earnedMoney, OrderDrink $orderDrink): EarnedMoney
    {
        $profit = $earnedMoney->getProfit();
        $profit += $orderDrink->money();
        $earnedMoney->setProfit($profit);

        return $earnedMoney;
    }

    /**
     * @param string $name
     * @return EarnedMoney|null
     */
    public function getDrinkByName(string $name): ?EarnedMoney
    {
        return $this->em->getRepository(EarnedMoney::class)->findOneBy(['drink' => $name]);

    }
}
