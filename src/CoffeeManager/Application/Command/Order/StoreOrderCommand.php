<?php

namespace App\CoffeeManager\Application\Command\Order;

use App\Shared\Domain\Bus\Command\Command;

readonly class StoreOrderCommand implements Command
{
    public function __construct(
        private string $type,
        private int $sugar,
        private bool $extraHot
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