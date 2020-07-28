<?php

namespace Deliverea\CoffeeMachine\Application\Command\Drink\Order;

use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order\Order;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;
use Deliverea\CoffeeMachine\Infrastructure\Shared\Bus\Command\CommandInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderDrinkCommand implements CommandInterface
{
    public Order $order;
    public OutputInterface $output;

    public function __construct(string $drink, float $money, int $sugars, bool $extraHot, OutputInterface $output)
    {
        $this->order = new Order(
            Name::fromString($drink),
            Money::fromFloat($money),
            Sugars::fromInt($sugars),
            $extraHot
        );

        $this->output = $output;
    }
}
