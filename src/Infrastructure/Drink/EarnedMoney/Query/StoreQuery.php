<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;

class StoreQuery extends AManagerQuery
{
    public function storeProfit(EarnedMoney $earnedMoney): void
    {
        $this->em->persist($earnedMoney);

        $this->em->flush();
    }
}