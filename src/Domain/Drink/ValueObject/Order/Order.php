<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order;

use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;

class Order
{
    private Name $name;

    private Money $money;

    private Sugars $sugars;

    private bool $extraHot;

    public function __construct(Name $name, Money $money, Sugars $sugars, bool $extraHot)
    {
        $this->name = $name;
        $this->money = $money;
        $this->sugars = $sugars;
        $this->extraHot = $extraHot;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getSugars(): Sugars
    {
        return $this->sugars;
    }

    public function getExtraHot(): bool
    {
        return $this->extraHot;
    }
}
