<?php

namespace Deliverea\CoffeeMachine\Domain\Drink;

use Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository\EarnedMoneyInterface;
use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order\Order;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkMoneySpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkSugarsSpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkTypeSpecification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class OrderDrink
{
    private string $name;

    private float $money;

    public function create(
        OutputInterface $output,
        Order $order,
        EarnedMoneyInterface $earnedMoneyRepository,
        DrinkTypeSpecification $drinkTypeSpecification,
        DrinkMoneySpecification $drinkMoneySpecification,
        DrinkSugarsSpecification $drinkSugarsSpecification
    ): int {

        try {
            $drinkTypeSpecification->isAvailableType($order->getName(), $output);
            $drinkMoneySpecification->haveEnoughMoney($order->getName(), $order->getMoney(), $output);
            $drinkSugarsSpecification->isAvailableSugars($order->getSugars(), $output);

        } catch (ValidationException $e) {
            return Command::FAILURE;
        }

        $output->write(
            $this->buildOrderMessage($order->getName(), $order->getExtraHot(), $order->getSugars())
        );

        $orderDrink = new self();
        $orderDrink->setName($order->getName());
        $orderDrink->setMoney($order->getMoney());

        $earnedMoneyRepository->store($orderDrink);

        return Command::SUCCESS;

    }

    private function buildOrderMessage(Name $name, bool $extraHot, Sugars $sugars): string
    {
        return ($this->setOrderName($name) . $this->setExtraHot($extraHot) . $this->setOrderSugars($sugars));
    }

    private function setOrderName(Name $name): string
    {
        return 'You have ordered a ' . $name->toString();
    }

    private function setOrderSugars(Sugars $sugars): string
    {
        return ($sugars->toInt() > 0) ? ' with ' . $sugars->toInt() . ' sugars (stick included)' : '';
    }

    private function setExtraHot(bool $extraHot): string
    {
        return ($extraHot === true) ? ' extra hot' : '';
    }

    private function setName(Name $name): void
    {
        $this->name = $name->toString();
    }

    private function setMoney(Money $money): void
    {
        $this->money = $money->toFloat();
    }

    public function name(): string
    {
        return $this->name;
    }
    public function money(): float
    {
        return $this->money;
    }

}
