<?php

namespace GetWith\CoffeeMachine\Tests\Unit\CoffeeManager\Domain\Order;

use App\CoffeeManager\Domain\Drink\Enum\DrinkPrices;
use App\CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use App\CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use App\CoffeeManager\Domain\Order\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function test_order_works()
    {
        $drinkType = DrinkTypes::COFFEE;

        $order = Order::build(
            $drinkType->value,
            DrinkPrices::byDrinkType($drinkType),
            rand(1, 2),
            boolval(rand(0, 1)),
            boolval(rand(0, 1))
        );

        $this->assertInstanceOf(Order::class, $order);
        $this->assertIsString($order->type()->value());
        $this->assertIsFloat($order->price()->value());
        $this->assertIsInt($order->sugar()->value());
        $this->assertEquals($drinkType->value, $order->type()->value());
    }

    public function test_order_type_fails()
    {
        $this->expectException(DrinkNotFound::class);

        Order::build(
            uniqid(),
            10,
            rand(1, 2),
            boolval(rand(0, 1)),
            boolval(rand(0, 1))
        );
    }
}