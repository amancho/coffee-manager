<?php

namespace App\CoffeeManager\Application\Command\Drink;

use App\CoffeeManager\Domain\Drink\DrinkService;
use App\Shared\Domain\Bus\Command\CommandHandler;

readonly class MakeDrinkCommandHandler implements CommandHandler
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