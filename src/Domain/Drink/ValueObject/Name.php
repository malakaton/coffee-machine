<?php

namespace Deliverea\CoffeeMachine\Domain\Drink\ValueObject;

class Name
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function toString(): string
    {
        return $this->type;
    }
}
