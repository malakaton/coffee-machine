<?php

namespace Deliverea\CoffeeMachine\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EarnedMoney
 * @ORM\Entity(repositoryClass=\Deliverea\CoffeeMachine\Infrastructure\Drink\EarnedMoney\Repository\EarnedMoneyRepository::class)
 */
class EarnedMoney
{
    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\Id
     */
    protected $drink;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $profit;

    public function setDrink(string $drink): void
    {
        $this->drink = $drink;
    }

    public function setProfit(float $profit): void
    {
        $this->profit = $profit;
    }

    /**
     * @return string
     */
    public function getDrink(): string
    {
        return $this->drink;
    }

    /**
     * @return float
     */
    public function getProfit(): float
    {
        return $this->profit;
    }
}