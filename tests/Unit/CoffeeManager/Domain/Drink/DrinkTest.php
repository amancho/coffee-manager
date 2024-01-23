<?php

namespace GetWith\CoffeeMachine\Tests\Unit\CoffeeManager\Domain\Drink;

use CoffeeManager\Domain\Drink\Drink;
use CoffeeManager\Domain\Drink\ValueObject\DrinkId;
use CoffeeManager\Domain\Drink\ValueObject\DrinkName;
use CoffeeManager\Domain\Drink\ValueObject\DrinkPrice;

use PHPUnit\Framework\TestCase;

class DrinkTest extends TestCase
{

    public function test_drink_works()
    {
        $id = random_int(1,99);
        $name= 'coffee';

        $drink = Drink::create(
            DrinkId::build($id),
            DrinkName::build($name),
            DrinkPrice::buildByName($name)
        );

        $this->assertInstanceOf(Drink::class, $drink);
        $this->assertIsInt($drink->id()->value());
        $this->assertIsString($drink->name()->value());
        $this->assertIsFloat($drink->price()->value());

        $this->assertEquals($drink->id()->value(), $id);
        $this->assertEquals($drink->name()->value(), $name);
    }
}
