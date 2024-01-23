<?php

namespace CoffeeManager\Infrastructure\Persistence\MySql;

use CoffeeManager\Domain\Order\Order;
use CoffeeManager\Domain\Order\OrderCollection;
use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Shared\Domain\InvalidCollectionObjectException;
use CoffeeManager\Shared\Infrastructure\Persistence\MySql\MySqlRepository;
use PDO;

final class OrderRepositoryMySql implements OrderRepository
{
    private PDO $client;

    public function __construct(PDO $client)
    {
        $this->client = $client;
    }

    public static function build(): OrderRepository
    {
        return new self(MySqlRepository::getClient());
    }

    public function store(Order $order): void
    {
        $stmt = $this->client->prepare('INSERT INTO orders (drink_type, price, sugars, stick, extra_hot) VALUES (:drink_type, :price, :sugars, :stick, :extra_hot)');
        $stmt->execute($this->toInfrastructure($order));
    }

    public function getOrdersMoneyByType(): array
    {
        $stmt = $this->client->query('SELECT drink_type, SUM(price) AS `amount` FROM orders GROUP BY drink_type');
        return $stmt->fetchAll();
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public function getAll(): OrderCollection
    {
        $stmt = $this->client->query('SELECT * FROM orders');
        $orders = $stmt->fetchAll();

        $orderCollection = OrderCollection::init();

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $orderCollection->add($this->toDomain($order));
            }
        }

        return $orderCollection;
    }

    private function toInfrastructure(Order $order): array
    {
        return [
            'drink_type' => $order->type()->value(),
            'price' => $order->price()->value(),
            'sugars' => $order->sugar()->value(),
            'stick' => $order->stick()->value() ?: 0,
            'extra_hot' => $order->extraHot()->value() ?: 0,
        ];
    }

    private function toDomain(array $order): Order
    {
        return Order::build(
            $order['drink_type'],
            (float) $order['price'],
            $order['sugars'],
            $order['stick'],
            $order['extra_hot']
        );
    }
}