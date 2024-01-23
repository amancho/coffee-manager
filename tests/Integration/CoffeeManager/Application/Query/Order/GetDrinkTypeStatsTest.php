<?php

namespace CoffeeManager\Tests\Integration\Application\Query\Order;

use CoffeeManager\Application\Query\Order\GetDrinkTypeStats\GetDrinkTypeStats;
use CoffeeManager\Application\Query\Order\GetDrinkTypeStats\GetDrinkTypeStatsQuery;
use CoffeeManager\Domain\Order\OrderRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetDrinkTypeStatsTest extends TestCase
{
    /** @var OrderRepository&MockObject  */
    private mixed $repository;
    private GetDrinkTypeStats $handler;
    private array $expectedResult;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(OrderRepository::class);
        $this->handler = new GetDrinkTypeStats($this->repository);

        $this->expectedResult = [
            [ 'drink_type' => 'coffee', 'amount' => 3.013 ],
            [ 'drink_type' => 'tea', 'amount' =>  2.014],
            [ 'drink_type' => 'chocolate', 'amount' =>  11.720 ],
        ];
    }

    public function test_get_drink_type_stats_size_works() : void
    {
        $this->repository
            ->expects(self::once())
            ->method('getOrdersMoneyByType')
            ->willReturn($this->expectedResult);

        $response = $this->handler->handle(new GetDrinkTypeStatsQuery());

        $this->assertSameSize($this->expectedResult, $response->toArray());
    }

    public function test_get_drink_type_stats_report_works() : void
    {
        $this->repository
            ->expects(self::once())
            ->method('getOrdersMoneyByType')
            ->willReturn($this->expectedResult);

        $report = $this->handler->handle(new GetDrinkTypeStatsQuery())->report();

        $this->assertStringContainsString('| Drink Type | Amount |', $report);
        $this->assertStringContainsString('tea          | 2.01€', $report);
        $this->assertStringContainsString('coffee       | 3.01€', $report);
        $this->assertStringContainsString('chocolate    | 11.72€', $report);
    }
}