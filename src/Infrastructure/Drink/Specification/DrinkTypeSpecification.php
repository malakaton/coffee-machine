<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\Model\Drink;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkTypeSpecification
{
    /**
     * @param Name $name
     * @param OutputInterface $output
     * @return bool|null ?bool
     */
    public function isAvailableType(Name $name, OutputInterface $output): ?bool
    {
        $drink = new Drink();

        if (!$drink->isAvailableDrink($name->toString())) {
            $error = 'The drink type should be ' . implode(', ', $drink->getTypes()->toArray());

            $output->write($error);

            throw new ValidationException($error);
        }

        return true;
    }
}