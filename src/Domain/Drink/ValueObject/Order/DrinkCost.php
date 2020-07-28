<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order;

use Deliverea\CoffeeMachine\Domain\Drink\Model\Drink;
use Deliverea\CoffeeMachine\Util\Collection\ExprMatcherArrayCollection;
use Doctrine\Common\Collections\ArrayCollection;

class DrinkCost extends ExprMatcherArrayCollection
{
    public function __construct()
    {
        parent::__construct($this->getCosts());
    }

    public function getCosts(): ArrayCollection
    {
        return new ArrayCollection(
            [
                [ 'name' => Drink::COFFEE_DRINK, 'cost' => 0.5 ],
                [ 'name' => Drink::TEA_DRINK, 'cost' => 0.4],
                [ 'name' => Drink::CHOCOLATE_DRINK, 'cost' => 0.6],
            ]
        );
    }

    public function getCostByDrink(string $attribute, string $value, string $operator = '='): float
    {
        $this->buildComparison($attribute, $value, $operator);
        $result = $this->match()->toArray();

        return array_shift($result)['cost'] ?? 0;
    }
}
