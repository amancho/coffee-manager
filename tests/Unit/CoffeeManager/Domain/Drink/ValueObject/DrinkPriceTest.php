<?php

namespace GetWith\CoffeeMachine\Tests\Unit\CoffeeManager\Domain\Drink\ValueObject;

use App\CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use App\CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use App\CoffeeManager\Domain\Drink\ValueObject\DrinkPrice;
use PHPUnit\Framework\TestCase;

class DrinkPriceTest extends TestCase
{
    public function test_drink_price_test_fails()
    {
        $this->expectException(DrinkNotFound::class);
        DrinkPrice::buildByName('test');
    }

    public function test_drink_price_test_works()
    {
        $drinkTypes = array_column(DrinkTypes::cases(), 'value');

        foreach($drinkTypes as $type){
            $drinkPrice = DrinkPrice::buildByName($type);
            $this->assertInstanceOf(DrinkPrice::class, $drinkPrice);
            $this->assertIsFloat($drinkPrice->value());
            $this->assertGreaterThanOrEqual(0.4, $drinkPrice->value());
        }
    }
}
