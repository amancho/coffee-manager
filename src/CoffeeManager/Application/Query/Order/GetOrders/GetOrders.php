<?php

namespace CoffeeManager\Application\Query\Order\GetOrders;

use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Shared\Bus\Application\Query;
use CoffeeManager\Shared\Bus\Application\QueryHandler;
use CoffeeManager\Shared\Bus\Application\QueryResponse;
use CoffeeManager\Shared\Domain\InvalidCollectionObjectException;

final class GetOrders extends QueryHandler
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    /**
     * @param GetOrdersQuery $query
     * @throws InvalidCollectionObjectException
     */
    public function handle(Query $query): QueryResponse
    {
        return GetOrdersResponse::build($this->orderRepository->getAll());
    }
}