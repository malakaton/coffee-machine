<?php

namespace Deliverea\CoffeeMachine\Tests\Unit\Infrastructure\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Money;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkMoneySpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkMoneySpecUnitTest extends TestCase
{

    protected Name $name;
    protected Money $money;
    protected OutputInterface $outputInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = new Name('tea');
        $this->money = new Money(0.9);
        $this->outputInterface = $this->createMock(OutputInterface::class);
    }

    /**
     * @test
     */
    public function have_enough_money_works(): void
    {
        $validation = (new DrinkMoneySpecification())->haveEnoughMoney(
            $this->name,
            $this->money,
            $this->outputInterface
        );


        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function not_have_enough_money_works(): void
    {
        $this->money = new Money(0.1);

        $this->expectException(ValidationException::class);

        (new DrinkMoneySpecification())->haveEnoughMoney(
            $this->name,
            $this->money,
            $this->outputInterface
        );
    }
}
