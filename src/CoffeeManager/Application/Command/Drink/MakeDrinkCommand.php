<?php

namespace CoffeeManager\Application\Command\Drink;

use CoffeeManager\Shared\Bus\Application\Command;

readonly class MakeDrinkCommand implements Command
{
    public function __construct(
        private string $type,
        private float $money,
        private int $sugars,
        private bool $extraHot = false
    ) {
    }

    public static function create(
        string $type,
        float $money,
        int $sugars,
        bool $extraHot = false
    ): MakeDrinkCommand {
        return new self(
            $type,
            $money,
            $sugars,
            $extraHot
        );
    }

    public function type(): string
    {
        return $this->type;
    }

    public function money(): float
    {
        return $this->money;
    }

    public function sugars(): int
    {
        return $this->sugars;
    }

    public function extraHot(): bool
    {
        return $this->extraHot;
    }
}