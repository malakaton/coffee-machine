<?php

namespace Deliverea\CoffeeMachine\Tests\Unit\Infrastructure\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Sugars;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkSugarsSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkSugarsSpecUnitTest extends TestCase
{

    protected Sugars $sugars;
    protected OutputInterface $outputInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sugars = new Sugars(1);
        $this->outputInterface = $this->createMock(OutputInterface::class);
    }

    /**
     * @test
     */
    public function validate_num_sugars_works(): void
    {
        $validation = (new DrinkSugarsSpecification())->isAvailableSugars(
            $this->sugars,
            $this->outputInterface
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function validate_num_sugars_fails(): void
    {
        $this->sugars = new Sugars(99999999);

        $this->expectException(ValidationException::class);

        (new DrinkSugarsSpecification())->isAvailableSugars(
            $this->sugars,
            $this->outputInterface
        );
    }
}
