<?php

namespace App\CoffeeManager\Domain\Drink\Enum;

enum DrinkTypes: string
{
    case COFFEE = 'coffee';
    case CHOCOLATE = 'chocolate';
    case TEA = 'tea';
}