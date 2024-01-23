<?php

namespace CoffeeManager\Application\Command\Order;

use CoffeeManager\Domain\Order\Order;
use CoffeeManager\Shared\Bus\Application\Command;

readonly class StoreOrderCommand implements Command
{
    public function __construct(private Order $order)
    {
    }

    public static function create(Order $order): StoreOrderCommand
    {
        return new self($order);
    }

    public function order(): Order
    {
        return $this->order;
    }
}