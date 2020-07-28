<?php

namespace Deliverea\CoffeeMachine\Tests\Unit\Infrastructure\Specification;

use Deliverea\CoffeeMachine\Domain\Drink\Exception\ValidationException;
use Deliverea\CoffeeMachine\Domain\Drink\ValueObject\Name;
use Deliverea\CoffeeMachine\Infrastructure\Drink\Specification\DrinkTypeSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkTypeSpecUnitTest extends TestCase
{

    protected Name $name;
    protected OutputInterface $outputInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = new Name('tea');
        $this->outputInterface = $this->createMock(OutputInterface::class);
    }

    /**
     * @test
     */
    public function validate_drink_type_works(): void
    {
        $validation = (new DrinkTypeSpecification())->isAvailableType(
            $this->name,
            $this->outputInterface
        );

        self::assertTrue($validation);
    }

    /**
     * @test
     */
    public function validate_drink_type_fails(): void
    {
        $this->name = new Name('fake');

        $this->expectException(ValidationException::class);

        (new DrinkTypeSpecification())->isAvailableType(
            $this->name,
            $this->outputInterface
        );
    }
}
