<?php

namespace Deliverea\CoffeeMachine\Tests\Unit\Infrastructure\Repository;

use Deliverea\CoffeeMachine\Domain\Entity\EarnedMoney;
use Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Query\GetQuery;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class EarnedMoneyRepoUnitTest extends TestCase
{
    /**
     * @test
     */
    public function return_earned_money_works(): void
    {
        $earnedMoney = new EarnedMoney();
        $earnedMoney->setDrink('tea');
        $earnedMoney->setProfit(9);

        $earnedMoneyRepo = $this->createMock(ObjectRepository::class);

        $earnedMoneyRepo->expects($this->any())
            ->method('findOneBy')
            ->willReturn($earnedMoney);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($earnedMoneyRepo);

        $earnedMoneyQuery = new GetQuery($objectManager);

        $result = $earnedMoneyQuery->getByName($earnedMoney->getDrink());

        self::assertEquals($earnedMoney, $result);
        self::assertEquals($earnedMoney->getProfit(), $result->getProfit());
    }
}