<?php

namespace CoffeeManager\Application\Query\Order\GetOrders;

use CoffeeManager\Domain\Order\Order;
use CoffeeManager\Domain\Order\OrderCollection;
use CoffeeManager\Shared\Bus\Application\QueryResponse;

final readonly class GetOrdersResponse implements QueryResponse
{
    public function __construct(private OrderCollection $orderCollection)
    {
    }

    public static function build(OrderCollection $orderCollection): GetOrdersResponse
    {
        return new self($orderCollection);
    }

    public function toArray(): array
    {
        $orders = [];

        /** @var Order $order */
        foreach ($this->orderCollection as $order) {
            $orders[] = $order->toArray();
        }

        return $orders;
    }

    public function report(): string
    {
        $report = 'Drink      | Price | Sugar   | Stick   | E.Hot' . PHP_EOL;
        $report .= '------------------------------------------- ' . PHP_EOL;

        /** @var Order $order */
        foreach ($this->orderCollection as $order) {
            $report .= $this->format($order->type()->value(), 10)
                . ' | ' . $this->format($order->currency())
                . ' | ' . $this->format($order->sugar()->value())
                . ' | ' . $this->format($order->stick()->value())
                . ' | ' . $this->format($order->extraHot()->value()) . PHP_EOL ;
        }

        return $report;
    }

    private function format(string $type, int $length = 7): string
    {
        return substr($type . '        ', 0, $length);
    }
}