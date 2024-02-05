<?php

namespace App\CoffeeManager\Domain\Drink;

use App\CoffeeManager\Domain\Drink\Error\DrinkIncorrectSugar;
use App\CoffeeManager\Domain\Drink\Error\DrinkLackOfMoney;
use App\CoffeeManager\Domain\Drink\ValueObject\DrinkPrice;

final class DrinkService
{
    public function make(
        string $type,
        float $money,
        int $sugars,
        bool $extraHot = false
    ): string {

        $this->sugarValidator($sugars);
        $this->priceValidator($type, $money);

        return $this->message($type, $sugars, $extraHot);
    }

    private function sugarValidator(int $sugars): void
    {
        if ($sugars < 0 || $sugars > 2) {
            throw new DrinkIncorrectSugar();
        }
    }

    private function priceValidator(string $type, float $money): void
    {
        $drinkPrice = DrinkPrice::buildByName($type);
        if ($money < $drinkPrice->value()) {
            throw new DrinkLackOfMoney($type, $drinkPrice->value());
        }
    }

    private function message(string $type, int $sugars, bool $extraHot): string
    {
        $message = 'You have ordered a ' . $type;
        if ($extraHot) {
            $message .= ' extra hot';
        }

        if (!empty($sugars)) {
            $message .= ' with ' . $sugars . ' sugars (stick included)';
        }

        return $message;
    }
}