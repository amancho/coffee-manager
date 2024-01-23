<?php

namespace CoffeeManager\Domain\Drink\ValueObject;

use CoffeeManager\Shared\Domain\ValueObject\IntValueObject;

final class DrinkId extends IntValueObject
{
    /**
     * @param int $value
     * @return self
     */
    public static function build(int $value): DrinkId
    {
        return new self($value);
    }
}
