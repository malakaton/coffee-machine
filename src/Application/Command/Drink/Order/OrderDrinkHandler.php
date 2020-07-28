<?php

namespace Deliverea\CoffeeMachine\Application\Command\Drink\Order;

use Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository\EarnedMoneyInterface;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkMoneySpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkSugarsSpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkTypeSpecification;
use Deliverea\CoffeeMachine\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;

class OrderDrinkHandler implements CommandHandlerInterface
{
    private EarnedMoneyInterface $earnedMoneyRepository;
    private DrinkTypeSpecification $drinkTypeSpecification;
    private DrinkMoneySpecification $drinkMoneySpecification;
    private DrinkSugarsSpecification $drinkSugarsSpecification;

    public function __construct(
        EarnedMoneyInterface $earnedMoneyRepository,
        DrinkTypeSpecification $drinkTypeSpecification,
        DrinkMoneySpecification $drinkMoneySpecification,
        DrinkSugarsSpecification $drinkSugarsSpecification
    ) {
        $this->earnedMoneyRepository = $earnedMoneyRepository;
        $this->drinkTypeSpecification = $drinkTypeSpecification;
        $this->drinkMoneySpecification = $drinkMoneySpecification;
        $this->drinkSugarsSpecification = $drinkSugarsSpecification;
    }

    public function __invoke(OrderDrinkCommand $command): int
    {
        return (new OrderDrink())->create(
            $command->output,
            $command->order,
            $this->earnedMoneyRepository,
            $this->drinkTypeSpecification,
            $this->drinkMoneySpecification,
            $this->drinkSugarsSpecification
        );
    }
}
