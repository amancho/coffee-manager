<?php

namespace CoffeeManager\Application\Query\Order\GetDrinkTypeStats;

use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Shared\Bus\Application\Query;
use CoffeeManager\Shared\Bus\Application\QueryHandler;
use CoffeeManager\Shared\Bus\Application\QueryResponse;

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