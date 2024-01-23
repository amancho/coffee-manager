<?php

namespace CoffeeManager\Shared\Bus\Domain;

use CoffeeManager\Shared\Bus\Application\Command;

interface CommandBus
{
    public function handle(Command $command): void;
}
