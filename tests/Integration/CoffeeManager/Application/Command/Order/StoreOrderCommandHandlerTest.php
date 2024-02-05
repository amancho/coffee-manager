<?php

namespace CoffeeManager\Tests\Integration\Application\Command\Order;

use App\CoffeeManager\Application\Command\Order\StoreOrderCommand;
use App\CoffeeManager\Application\Command\Order\StoreOrderCommandHandler;
use App\CoffeeManager\Domain\Drink\Enum\DrinkPrices;
use App\CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use App\CoffeeManager\Domain\Order\Order;
use App\CoffeeManager\Domain\Order\OrderRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StoreOrderCommandHandlerTest extends TestCase
{
    /** @var OrderRepository&MockObject  */
    private mixed $repository;
    private StoreOrderCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(OrderRepository::class);
        $this->handler = new StoreOrderCommandHandler($this->repository);
    }

    public function test_should_call_store_repository(): void
    {
        $order = Order::build(
            DrinkTypes::COFFEE->value,
            DrinkPrices::byDrinkType(DrinkTypes::COFFEE),
            1,
            true,
            true
        );

        $this->repository
            ->expects(self::once())
            ->method('store')
            ->with($order);

        $this->handler->__invoke(new StoreOrderCommand(
                $order->type()->value(),
                $order->sugar()->value(),
                $order->extraHot()->value()
            )
        );
    }
}