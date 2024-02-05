<?php

namespace App\CoffeeManager\Domain\Order\ValueObject;

use App\Shared\Domain\ValueObject\BooleanValueObject;

final class OrderExtraHot extends BooleanValueObject
{
    /**
     * @param bool $value
     * @return self
     */
    public static function build(bool $value): OrderExtraHot
    {
        return new self($value);
    }
}