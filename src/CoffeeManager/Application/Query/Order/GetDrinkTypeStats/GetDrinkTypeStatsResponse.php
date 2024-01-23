<?php

namespace CoffeeManager\Application\Query\Order\GetDrinkTypeStats;

use CoffeeManager\Shared\Bus\Application\QueryResponse;

final readonly class GetDrinkTypeStatsResponse implements QueryResponse
{
    public function __construct(private array $drinkTypes)
    {
    }

    public static function build(array $drinkTypes): GetDrinkTypeStatsResponse
    {
        return new self($drinkTypes);
    }

    public function toArray(): array
    {
        return $this->drinkTypes;
    }

    public function report(): string
    {
        $report = '| Drink Type | Amount |' . PHP_EOL;
        $report .= '|------------|--------| ' . PHP_EOL;

        /** @var $drinkType array<string, float> */
        foreach ($this->drinkTypes as $drinkType) {
            $report .= $this->format($drinkType['drink_type'])
                . ' | ' . $this->formatCurrency($drinkType['amount'])
                . ' | ' . PHP_EOL ;
        }

        return $report;
    }

    public function formatCurrency(string $value): string
    {
        return $this->format(round($value, 2) .  '€', 8);
    }

    private function format(string $type, int $length = 12): string
    {
        return substr($type . '         ', 0, $length);
    }
}