<?php

namespace CoffeeManager\Tests\Integration\Application\Query\Order;

use App\CoffeeManager\Application\Query\Order\GetOrders\GetOrders;
use App\CoffeeManager\Application\Query\Order\GetOrders\GetOrdersQuery;
use App\CoffeeManager\Domain\Order\Order;
use App\CoffeeManager\Domain\Order\OrderCollection;
use App\CoffeeManager\Domain\Order\OrderRepository;
use App\Shared\Domain\InvalidCollectionObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetOrdersTest extends TestCase
{
    /** @var OrderRepository&MockObject  */
    private mixed $repository;
    private GetOrders $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(OrderRepository::class);
        $this->handler = new GetOrders($this->repository);
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public function test_get_orders_size_works() : void
    {
        $orderCollection = OrderCollection::create($this->getOrders());

        $this->repository
            ->expects(self::once())
            ->method('getAll')
            ->willReturn($orderCollection);

        $response = $this->handler->handle(new GetOrdersQuery());
        $this->assertCount($orderCollection->count(), $response->toArray());
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public function test_get_orders_report_works() : void
    {
        $orderCollection = OrderCollection::create($this->getOrders());

        $this->repository
            ->expects(self::once())
            ->method('getAll')
            ->willReturn($orderCollection);

        $report = $this->handler->handle(new GetOrdersQuery())->report();

        $this->assertStringContainsString('Drink      | Price | Sugar   | Stick   | E.Hot' . PHP_EOL, $report);
        $this->assertStringContainsString('tea', $report);
        $this->assertStringContainsString('coffee', $report);
        $this->assertStringContainsString('chocolate', $report);
    }

    private function getOrders(): array
    {
        return [
            Order::buildBasic('chocolate', 0),
            Order::buildBasic('tea', 1),
            Order::buildBasic('coffee', 2),
        ];
    }
}