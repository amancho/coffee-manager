<?php

namespace CoffeeManager\Application\Command\Drink;

use CoffeeManager\Domain\Drink\DrinkService;
use CoffeeManager\Shared\Bus\Application\Handler;

readonly class MakeDrinkCommandHandler implements Handler
{

    public function __construct(
        private DrinkService $drinkService
    ) {
    }

    public function handle(MakeDrinkCommand $command): string
    {
        return $this->drinkService->make(
            $command->type(),
            $command->money(),
            $command->sugars(),
            $command->extraHot()
        );
    }
}