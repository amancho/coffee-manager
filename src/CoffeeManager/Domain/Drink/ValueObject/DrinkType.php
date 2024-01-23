<?php

namespace CoffeeManager\Domain\Drink\ValueObject;

use CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use CoffeeManager\Shared\Domain\ValueObject\StringValueObject;

final class DrinkType extends StringValueObject
{
    /**
     * @param string $value
     * @return self
     */
    public static function build(string $value): DrinkType
    {
        $drinkType = DrinkTypes::tryFrom($value);
        if ($drinkType == null) {
            throw new DrinkNotFound();
        }

        return new self($value);
    }
}