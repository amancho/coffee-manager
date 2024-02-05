<?php

namespace App\CoffeeManager\Application\Query\Order\GetDrinkTypeStats;

use App\CoffeeManager\Domain\Order\OrderRepository;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\Bus\Query\QueryResponse;

final class GetDrinkTypeStats extends QueryHandler
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    /**
     * @param GetDrinkTypeStatsQuery $query
     */
    public function handle(Query $query): QueryResponse
    {
        return GetDrinkTypeStatsResponse::build($this->orderRepository->getOrdersMoneyByType());
    }
}