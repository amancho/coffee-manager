<?php

namespace CoffeeManager\Domain\Drink\ValueObject;

use CoffeeManager\Domain\Drink\Enum\DrinkPrices;
use CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use CoffeeManager\Shared\Domain\ValueObject\FloatValueObject;

final class DrinkPrice extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }

    public static function build(float $value): DrinkPrice
    {
        return new self($value);
    }

    /**
     * @param string $name
     * @return self
     */
    public static function buildByName(string $name): DrinkPrice
    {
        $drinkType = DrinkTypes::tryFrom($name);
        if ($drinkType == null) {
            throw new DrinkNotFound();
        }

        return new self(DrinkPrices::byDrinkType($drinkType));
    }
}