<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query;

class GetQuery extends AManagerQuery
{
    /**
     * @param string $drinkName
     * @param float $profit
     * @return float|null
     */
    public function sumProfit(string $drinkName, float $profit): float
    {
        $earnedMoney = $this->earnedMoneyRepository->findOneBy(['drink' => $drinkName]);

        return is_null($earnedMoney) ? (0.0 + $profit) : ($earnedMoney->getProfit() + $profit);
    }

    /**
     * @param string $drinkName
     * @return object|null
     */
    public function getByName(string $drinkName): ?object
    {
        return $this->earnedMoneyRepository->findOneBy(['drink' => $drinkName]);
    }
}