<?php

namespace Deliverea\CoffeeMachine\Tests\Integration\Console;

use Deliverea\CoffeeMachine\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MakeDrinkCommandTest extends IntegrationTestCase
{
    protected $command;
    protected CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = $this->application->find('app:order-drink');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @dataProvider ordersProvider
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        string $money,
        int $sugars,
        string $extraHot,
        string $expectedOutput
    ): void {

        $this->commandTester->execute(array(
            'command'  => $this->command->getName(),

            // pass arguments to the helper
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
            '--extra-hot' => $extraHot
        ));

        // the output of the command in the console
        $output = $this->commandTester->getDisplay();
        self::assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function invalid_drink_type_call_validation_exception(): void
    {
        $this->commandTester->execute(array(
            'command'  => $this->command->getName(),

            // pass arguments to the helper
            'drink-type' => 'fake',
            'money' => 1,
            'sugars' => 0,
            '--extra-hot' => false
        ));

        $output = $this->commandTester->getDisplay();
        self::assertEquals("The drink type should be coffee, tea, chocolate", $output);
    }

    /**
     * @test
     */
    public function invalid_not_enough_money_call_validation_exception(): void
    {
        $this->commandTester->execute(array(
            'command'  => $this->command->getName(),

            // pass arguments to the helper
            'drink-type' => 'tea',
            'money' => 0.2,
            'sugars' => 0,
            '--extra-hot' => false
        ));

        $output = $this->commandTester->getDisplay();
        self::assertEquals("The tea costs 0.4.", $output);
    }

    /**
     * @test
     */
    public function invalid_num_sugars_call_validation_exception(): void
    {
        $this->commandTester->execute(array(
            'command'  => $this->command->getName(),

            // pass arguments to the helper
            'drink-type' => 'tea',
            'money' => 1,
            'sugars' => 999,
            '--extra-hot' => false
        ));

        $output = $this->commandTester->getDisplay();
        self::assertEquals("The number of sugars should be between 0 and 2.", $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'chocolate', '0.7', 1, '', 'You have ordered a chocolate with 1 sugars (stick included)'
            ],
            [
                'tea', '0.4', 0, 1, 'You have ordered a tea extra hot'
            ],
            [
                'coffee', '2', 2, 1, 'You have ordered a coffee extra hot with 2 sugars (stick included)'
            ],
            [
                'coffee', '0.2', 2, 1, 'The coffee costs 0.5.'
            ],
            [
                'chocolate', '0.3', 2, 1, 'The chocolate costs 0.6.'
            ],
            [
                'tea', '0.1', 2, 1, 'The tea costs 0.4.'
            ],
            [
                'tea', '0.5', -1, 1, 'The number of sugars should be between 0 and 2.'
            ],
            [
                'tea', '0.5', 3, 1, 'The number of sugars should be between 0 and 2.'
            ],
        ];
    }
}
