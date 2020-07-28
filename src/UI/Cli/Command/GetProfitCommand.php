<?php

namespace Deliverea\CoffeeMachine\UI\Cli\Command;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Repository\EarnedMoneyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetProfitCommand extends Command
{
    private EarnedMoneyRepository $earnedMoneyRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->earnedMoneyRepository = $entityManager->getRepository(EarnedMoney::class);

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:get-profit');
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
        $output->writeln('<comment>Drink   Money</comment>');
        foreach ($this->earnedMoneyRepository->findAll() as $profit) {
            $output->writeln('<fg=black;bg=green>' . $profit->getDrink() . '    ' . $profit->getProfit() . '</>');

        }

        return Command::SUCCESS;
    }
}
