<?php

namespace CoffeeManager\Application\Command\Order;

use CoffeeManager\Domain\Order\Order;
use CoffeeManager\Shared\Bus\Application\Command;

readonly class StoreOrderCommand implements Command
{
    public function __construct(
        private readonly string $type,
        private readonly int $sugar,
        private readonly bool $extraHot
    )
    {
    }

    public static function create(string $type, int $sugar, bool $extraHot): StoreOrderCommand
    {
        return new self($type, $sugar, $extraHot);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function sugar(): int
    {
        return $this->sugar;
    }

    public function extraHot(): bool
    {
        return $this->extraHot;
    }
}