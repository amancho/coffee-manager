<?php

namespace CoffeeManager\Application\Command\Order;

use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Shared\Bus\Application\Handler;

readonly class StoreOrderCommandHandler implements Handler
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function handle(StoreOrderCommand $command): void
    {
        $this->repository->store($command->order());
    }
}