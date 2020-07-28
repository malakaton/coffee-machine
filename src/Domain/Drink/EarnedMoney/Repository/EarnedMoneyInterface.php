<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;

interface EarnedMoneyInterface
{
    public function getDrinkByName(string $name): ?EarnedMoney;

    public function store(OrderDrink $drink): void;

    public function create(OrderDrink $orderDrink): EarnedMoney;

    public function updateProfit(EarnedMoney $earnedMoney, OrderDrink $orderDrink): EarnedMoney;
}
