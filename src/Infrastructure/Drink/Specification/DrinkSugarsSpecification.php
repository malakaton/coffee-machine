<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Drink\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkSugarsSpecification
{
    /**
     * @param Sugars $sugars
     * @return string|null
     */
    public function isAvailableSugars(Sugars $sugars, OutputInterface $output): ?bool
    {
        if (!in_array($sugars->toInt(), $sugars->getAvailableSugars(), true)) {
            $error = 'The number of sugars should be between ' . $sugars->getAvailableSugars()[0] . ' and ' .
                $sugars->getAvailableSugars()[count($sugars->getAvailableSugars()) - 1] . '.';

            $output->write($error);

            throw new ValidationException($error);
        }

        return true;
    }
}