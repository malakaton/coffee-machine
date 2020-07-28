<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order\DrinkCost;
use Symfony\Component\Console\Output\OutputInterface;

final class DrinkMoneySpecification
{
    /**
     * @param Name $name
     * @param Money $money
     * @return bool|null ?bool
     */
    public function haveEnoughMoney(Name $name, Money $money, OutputInterface $output): ?bool
    {
        $cost = (new DrinkCost())->getCostByDrink('name', $name->toString());

        if ($money->toFloat() < $cost) {
            $error = 'The ' . $name->toString() . ' costs ' . $cost . '.';

            $output->write($error);

            throw new ValidationException($error);
        }

        return true;
    }
}