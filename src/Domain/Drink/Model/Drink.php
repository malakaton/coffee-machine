<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Drink
{
    public const COFFEE_DRINK = 'coffee';
    public const TEA_DRINK = 'tea';
    public const CHOCOLATE_DRINK = 'chocolate';

    public function getTypes(): ArrayCollection
    {
        return new ArrayCollection(
            [
                self::COFFEE_DRINK,
                self::TEA_DRINK,
                self::CHOCOLATE_DRINK,
            ]
        );
    }

    public function isAvailableDrink(string $value): bool
    {
        if (!in_array($value, $this->getTypes()->toArray(), true)) {
            return false;
        }

        return true;
    }
}
