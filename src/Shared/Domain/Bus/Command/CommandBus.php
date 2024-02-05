<?php

namespace App\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function handle(Command $command): void;
}
