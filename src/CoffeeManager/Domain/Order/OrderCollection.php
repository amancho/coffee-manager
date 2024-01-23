<?php

namespace CoffeeManager\Domain\Order;

use CoffeeManager\Shared\Domain\Collection;
use CoffeeManager\Shared\Domain\InvalidCollectionObjectException;

class OrderCollection extends Collection
{
    protected function type(): string
    {
        return Order::class;
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public static function init(): self
    {
        return new static([]);
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public static function create(array $orders): self
    {
        return new self($orders);
    }
}