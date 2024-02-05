<?php

namespace App\CoffeeManager\Domain\Order;

use App\Shared\Domain\Collection;
use App\Shared\Domain\InvalidCollectionObjectException;

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
        return new OrderCollection([]);
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public static function create(array $orders): self
    {
        return new self($orders);
    }
}