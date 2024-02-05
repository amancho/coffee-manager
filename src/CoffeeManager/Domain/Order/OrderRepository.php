<?php

namespace App\CoffeeManager\Domain\Order;

use App\Shared\Domain\InvalidCollectionObjectException;

interface OrderRepository
{
    public function store(Order $order): void;

    /**
     * @throws InvalidCollectionObjectException
     */
    public function getAll(): OrderCollection;

    public function getOrdersMoneyByType(): array;
}