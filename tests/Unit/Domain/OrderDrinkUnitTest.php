<?php

namespace Deliverea\CoffeeMachine\Tests\Unit\Domain;

use Deliverea\CoffeeMachine\Domain\Drink\EarnedMoney\Repository\EarnedMoneyInterface;
use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\OrderDrink;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Order\Order;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkMoneySpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkSugarsSpecification;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkTypeSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class OrderDrinkUnitTest extends TestCase
{
    protected $mockedTypeSpecClass;
    protected $mockedMoneySpecClass;
    protected $mockedSugarsSpecClass;
    protected $mockedRepoInterface;
    protected $mockedOutput;
    protected $mockedOrderValueObj;
    protected orderDrink $orderDrink;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockedTypeSpecClass = $this->createMock(DrinkTypeSpecification::class);
        $this->mockedMoneySpecClass = $this->createMock(DrinkMoneySpecification::class);
        $this->mockedSugarsSpecClass = $this->createMock(DrinkSugarsSpecification::class);
        $this->mockedRepoInterface = $this->createMock(EarnedMoneyInterface::class);
        $this->mockedOutput = $this->createMock(OutputInterface::class);
        $this->mockedOrderValueObj = $this->createMock(Order::class);
        $this->orderDrink = new OrderDrink();
    }

    /**
     * @test
     */
    public function order_drink_create_works(): void
    {
        $this->mockedOrderValueObj->method('getName')->willReturn(new Name('tea'));
        $this->mockedOrderValueObj->method('getMoney')->willReturn(new Money(0.7));
        $this->mockedOrderValueObj->method('getSugars')->willReturn(new Sugars(0));
        $this->mockedOrderValueObj->method('getExtraHot')->willReturn(false);
        $this->mockedTypeSpecClass->method('isAvailableType')->willReturn(true);
        $this->mockedSugarsSpecClass->method('isAvailableSugars')->willReturn(true);

        $result = $this->orderDrink->create(
            $this->mockedOutput,
            $this->mockedOrderValueObj,
            $this->mockedRepoInterface,
            $this->mockedTypeSpecClass,
            $this->mockedMoneySpecClass,
            $this->mockedSugarsSpecClass
        );

        self::assertEquals(Command::SUCCESS, $result);
    }

    /**
     * @test
     */
    public function order_drink_create_fails(): void
    {
        $this->mockedOrderValueObj->method('getName')->willReturn(new Name('fake'));
        $this->mockedOrderValueObj->method('getMoney')->willReturn(new Money(0.8));
        $this->mockedOrderValueObj->method('getSugars')->willReturn(new Sugars(0));
        $this->mockedOrderValueObj->method('getExtraHot')->willReturn(false);
        $this->mockedTypeSpecClass->method('isAvailableType')->willReturn(null)->willThrowException(new ValidationException('error'));
        $this->mockedMoneySpecClass->method('haveEnoughMoney')->willReturn(true);
        $this->mockedSugarsSpecClass->method('isAvailableSugars')->willReturn(true);

        $result = $this->orderDrink->create(
            $this->mockedOutput,
            $this->mockedOrderValueObj,
            $this->mockedRepoInterface,
            $this->mockedTypeSpecClass,
            $this->mockedMoneySpecClass,
            $this->mockedSugarsSpecClass
        );

        self::assertEquals(Command::FAILURE, $result);
    }
}
