<?php

namespace CoffeeManager\Domain\Order;

use CoffeeManager\Shared\Domain\InvalidCollectionObjectException;

interface OrderRepository
{
    public function store(Order $order): void;

    /**
     * @throws InvalidCollectionObjectException
     */
    public function getAll(): OrderCollection;

    public function getOrdersMoneyByType(): array;
}