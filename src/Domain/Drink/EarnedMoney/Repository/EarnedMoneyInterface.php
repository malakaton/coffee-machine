<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;

interface EarnedMoneyInterface
{
    public function store(OrderDrink $drink): void;
}
