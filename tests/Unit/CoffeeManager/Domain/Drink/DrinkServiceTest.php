<?php

namespace Tests\Unit\CoffeeManager\Domain\Drink;

use CoffeeManager\Domain\Drink\DrinkService;
use CoffeeManager\Domain\Drink\Enum\DrinkTypes;
use CoffeeManager\Domain\Drink\Error\DrinkIncorrectSugar;
use CoffeeManager\Domain\Drink\Error\DrinkLackOfMoney;
use CoffeeManager\Domain\Drink\Error\DrinkNotFound;
use PHPUnit\Framework\TestCase;

final class DrinkServiceTest extends TestCase
{
    private DrinkService $sut;
    private array $drinkTypes;

    protected function setUp(): void
    {
        $this->sut = new DrinkService();
        $this->drinkTypes = array_column(DrinkTypes::cases(), 'value');
    }

    public function test_drink_type_find_fails(): void
    {
        $this->expectException(DrinkNotFound::class);
        $type = substr(str_shuffle('abcdefgh'), 0,5);

        $this->sut->make($type, 0.3, 0);
    }

    public function test_money_check_fails(): void
    {
        $this->expectException(DrinkLackOfMoney::class);

        foreach ($this->drinkTypes as $drinkType) {
            $this->sut->make($drinkType, 0.1, 0);
        }
    }

    public function test_money_check_works(): void
    {
        foreach ($this->drinkTypes as $drinkType) {
            $message = $this->sut->make($drinkType, 0.9, 0);
            $this->assertStringContainsString($drinkType, $message);
        }
    }

    public function test_sugar_check_works(): void
    {
        $message = $this->sut->make(DrinkTypes::CHOCOLATE->value, 0.9, rand(1,2));
        $this->assertStringContainsString(DrinkTypes::CHOCOLATE->value, $message);
    }

    /**
     * @dataProvider getSugars
     */
    public function test_less_sugar_check_drink_fails(string $type, int $sugars): void
    {
        $this->expectException(DrinkIncorrectSugar::class);
        $this->sut->make($type, 0.9, $sugars);
    }

    public function getSugars(): array
    {
        return [
            'less sugar' => [
                'type' => DrinkTypes::CHOCOLATE->value,
                'sugars' => -1
            ],
            'too much sugar' => [
                'type' => DrinkTypes::CHOCOLATE->value,
                'sugars' => 3
            ],
        ];
    }
}
