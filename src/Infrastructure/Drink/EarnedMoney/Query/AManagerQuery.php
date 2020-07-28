<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

abstract class AManagerQuery
{
    protected ObjectRepository $earnedMoneyRepository;
    protected ObjectManager $em;

    public function __construct(ObjectManager $objectManager)
    {
        $this->em = $objectManager;
        $this->earnedMoneyRepository = $objectManager
            ->getRepository(EarnedMoney::class);
    }
}