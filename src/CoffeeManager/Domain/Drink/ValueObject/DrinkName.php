<?php

namespace App\CoffeeManager\Domain\Drink\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

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
