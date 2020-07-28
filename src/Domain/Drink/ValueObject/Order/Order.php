<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order;

use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;

class Order
{
    public Name $name;

    public Money $money;

    public Sugars $sugars;

    public bool $extraHot;

    public function __construct(Name $name, Money $money, Sugars $sugars, bool $extraHot)
    {
        $this->name = $name;
        $this->money = $money;
        $this->sugars = $sugars;
        $this->extraHot = $extraHot;
    }
}
