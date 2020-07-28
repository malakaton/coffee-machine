<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject;

class Sugars
{
    private int $sugars;
    private array $availableSugars = [0, 1, 2];

    public function __construct(int $sugars)
    {
        $this->sugars = $sugars;
    }

    public static function fromInt(string $sugars): self
    {
        return new self($sugars);
    }

    public function toInt(): int
    {
        return $this->sugars;
    }

    public function getAvailableSugars(): array
    {
        return $this->availableSugars;
    }
}
