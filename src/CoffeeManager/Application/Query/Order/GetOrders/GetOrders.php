<?php

namespace App\CoffeeManager\Application\Query\Order\GetOrders;

use App\CoffeeManager\Domain\Order\OrderRepository;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\Bus\Query\QueryResponse;
use App\Shared\Domain\InvalidCollectionObjectException;

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