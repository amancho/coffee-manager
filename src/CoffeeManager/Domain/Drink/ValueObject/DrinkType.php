<?php

namespace App\CoffeeManager\Domain\Drink\ValueObject;

use App\CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use App\CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use App\Shared\Domain\ValueObject\StringValueObject;

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