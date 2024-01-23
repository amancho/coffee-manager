<?php

namespace CoffeeManager\Domain\Order\ValueObject;

use CoffeeManager\Shared\Domain\ValueObject\IntValueObject;

final class OrderSugar extends IntValueObject
{
    /**
     * @param float $value
     * @return self
     */
    public static function build(float $value): OrderSugar
    {
        return new self($value);
    }
}