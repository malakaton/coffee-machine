<?php

namespace Deliverea\CoffeeMachine\UI\Cli\Command;

use Deliverea\CoffeeMachine\Application\Command\Drink\Order\OrderDrinkCommand as OrderDrink;
use Deliverea\CoffeeMachine\Infrastructure\Shared\Bus\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class MakeDrinkCommand extends Command
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:order-drink')
            ->addArgument(
                'drink-type',
                InputArgument::REQUIRED,
                'The type of the drink. (Tea, Coffee or Chocolate)'
            )
            ->addArgument(
                'money',
                InputArgument::REQUIRED,
                'The amount of money given by the user'
            )
            ->addArgument(
                'sugars',
                InputArgument::OPTIONAL,
                'The number of sugars you want. (0, 1, 2)',
                0
            )
            ->addOption(
                'extra-hot',
                null,
                InputOption::VALUE_NONE,
                'If the user wants to make the drink extra hot'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Assert\AssertionFailedException
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new OrderDrink(
            strtolower($input->getArgument('drink-type')),
            $input->getArgument('money'),
            $input->getArgument('sugars'),
            $input->getOption('extra-hot'),
            $output
        );

        $this->commandBus->handle($command);

        return $this->commandBus->getCommandStatus();
    }
}
