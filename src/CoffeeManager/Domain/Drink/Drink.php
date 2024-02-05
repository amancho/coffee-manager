<?php

namespace App\CoffeeManager\Domain\Drink;

use App\CoffeeManager\Domain\Drink\ValueObject\DrinkId;
use App\CoffeeManager\Domain\Drink\ValueObject\DrinkName;
use App\CoffeeManager\Domain\Drink\ValueObject\DrinkPrice;

final class Drink
{
    private DrinkId $id;
    private DrinkName $name;
    private DrinkPrice $price;

    public function __construct(DrinkId $id, DrinkName $name, DrinkPrice $price
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @param DrinkId $id
     * @param DrinkName $name
     * @param DrinkPrice $price
     * @return Drink
     */
    public static function create(
        DrinkId $id,
        DrinkName $name,
        DrinkPrice $price
    ): Drink {
        return new self($id, $name, $price);
    }

    public static function build(int $id, string $name): Drink
    {
        return self::create(
            DrinkId::build($id),
            DrinkName::build($name),
            DrinkPrice::buildByName($name)
        );
    }

    public function id(): DrinkId
    {
        return $this->id;
    }

    public function name(): DrinkName
    {
        return $this->name;
    }

    public function price(): DrinkPrice
    {
        return $this->price;
    }
}