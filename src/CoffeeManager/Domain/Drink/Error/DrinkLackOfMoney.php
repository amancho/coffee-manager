<?php

namespace CoffeeManager\Domain\Drink\Error;

use CoffeeManager\Shared\Domain\DomainError;

final class DrinkLackOfMoney extends DomainError
{
    private string $type;
    private float $cost;

    public function __construct(string $type, float $cost)
    {
        $this->type = $type;
        $this->cost = $cost;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'drink_lack_of_money';
    }

    protected function errorMessage(): string
    {
        return sprintf('The %s costs %g.', $this->type, $this->cost);
    }
}