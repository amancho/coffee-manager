<?php

namespace CoffeeManager\Domain\Drink\ValueObject;

use CoffeeManager\Shared\Domain\ValueObject\StringValueObject;

final class DrinkName extends StringValueObject
{
    /**
     * @param string $value
     * @return self
     */
    public static function build(string $value): DrinkName
    {
        return new self($value);
    }
}
