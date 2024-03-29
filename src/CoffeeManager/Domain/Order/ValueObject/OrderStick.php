<?php

namespace App\CoffeeManager\Domain\Order\ValueObject;

use App\Shared\Domain\ValueObject\BooleanValueObject;

final class OrderStick extends BooleanValueObject
{
    /**
     * @param bool $value
     * @return self
     */
    public static function build(bool $value): OrderStick
    {
        return new self($value);
    }
}