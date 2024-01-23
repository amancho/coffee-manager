<?php

namespace CoffeeManager\Shared\Bus\Domain;

use CoffeeManager\Shared\Bus\Application\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
