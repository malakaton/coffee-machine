<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject;

class Money
{
    private float $money;

    private function __construct(float $money)
    {
        $this->money = $money;
    }

    public static function fromFloat(string $money): self
    {
        return new self($money);
    }

    public function toFloat(): float
    {
        return $this->money;
    }
}
