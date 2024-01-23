<?php

namespace CoffeeManager\Domain\Drink\Enum;

enum DrinkPrices: string
{
    case COFFEE = '0.5';
    case CHOCOLATE = '0.6';
    case TEA = '0.4';

    public static function byDrinkType(DrinkTypes $drinkType): float
    {
        return match ($drinkType) {
            DrinkTypes::COFFEE => (float) self::COFFEE->value,
            DrinkTypes::CHOCOLATE => (float) self::CHOCOLATE->value,
            DrinkTypes::TEA => (float) self::TEA->value,
        };
    }
}