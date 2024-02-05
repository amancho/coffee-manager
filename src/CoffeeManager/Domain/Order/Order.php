<?php

namespace App\CoffeeManager\Domain\Order;

use App\CoffeeManager\Domain\Drink\ValueObject\DrinkPrice;
use App\CoffeeManager\Domain\Drink\ValueObject\DrinkType;
use App\CoffeeManager\Domain\Order\ValueObject\OrderExtraHot;
use App\CoffeeManager\Domain\Order\ValueObject\OrderPrice;
use App\CoffeeManager\Domain\Order\ValueObject\OrderStick;
use App\CoffeeManager\Domain\Order\ValueObject\OrderSugar;

final class Order
{
    const DEFAULT_CURRENCY = '€';

    public function __construct(
        private readonly DrinkType $type,
        private readonly OrderPrice $price,
        private readonly OrderSugar $sugar,
        private readonly OrderStick $stick,
        private readonly OrderExtraHot $extraHot
    ) {
    }

    /**
     * Create new order instance
     *
     * @param DrinkType $type
     * @param OrderPrice $price
     * @param OrderSugar $sugar
     * @param OrderStick $stick
     * @param OrderExtraHot $extraHot
     * @return Order
     */
    public static function create(
        DrinkType $type,
        OrderPrice $price,
        OrderSugar $sugar,
        OrderStick $stick,
        OrderExtraHot $extraHot
    ): Order {
        return new self($type, $price, $sugar, $stick, $extraHot);
    }

    public static function build(
        string $type,
        float $price,
        int $sugar,
        bool $stick = false,
        bool $extraHot = false
    ): Order {
        return Order::create(
            DrinkType::build($type),
            OrderPrice::build($price),
            OrderSugar::build($sugar),
            OrderStick::build($stick),
            OrderExtraHot::build($extraHot)
        );
    }

    public static function buildBasic(
        string $type,
        int $sugar,
        bool $extraHot = false
    ): Order {
        return Order::create(
            DrinkType::build($type),
            OrderPrice::build(DrinkPrice::buildByName($type)->value()),
            OrderSugar::build($sugar),
            OrderStick::build(!empty($sugar)),
            OrderExtraHot::build($extraHot)
        );
    }

    public function type(): DrinkType
    {
        return $this->type;
    }

    public function sugar(): OrderSugar
    {
        return $this->sugar;
    }

    public function stick(): OrderStick
    {
        return $this->stick;
    }

    public function extraHot(): OrderExtraHot
    {
        return $this->extraHot;
    }

    public function price(): OrderPrice
    {
        return $this->price;
    }

    public function currency(string $currencySimbol = self::DEFAULT_CURRENCY): string
    {
        return round($this->price->value(), 2) . $currencySimbol;
    }

    public function toArray(): array
    {
        return [
            'drink_type' => $this->type()->value(),
            'price' => $this->price()->value(),
            'sugars' => $this->sugar()->value(),
            'stick' => $this->stick()->value() ?: 0,
            'extra_hot' => $this->extraHot()->value() ?: 0,
        ];
    }
}