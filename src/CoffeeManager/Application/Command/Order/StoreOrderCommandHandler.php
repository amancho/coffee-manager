<?php

namespace App\CoffeeManager\Application\Command\Order;

use App\CoffeeManager\Domain\Order\Order;
use App\CoffeeManager\Domain\Order\OrderRepository;
use App\Shared\Domain\Bus\Command\CommandHandler;

readonly class StoreOrderCommandHandler implements CommandHandler
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function __invoke(StoreOrderCommand $command): void
    {
        $order = Order::buildBasic(
            $command->type(),
            $command->sugar(),
            $command->extraHot()
        );

        $this->repository->store($order);
    }
}