<?php

namespace CoffeeManager\Domain\Order\ValueObject;

use CoffeeManager\Shared\Domain\ValueObject\FloatValueObject;

final class OrderPrice extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }

    /**
     * @param float $value
     * @return self
     */
    public static function build(float $value): OrderPrice
    {
        return new self($value);
    }
}