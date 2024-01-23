<?php

namespace CoffeeManager\Shared\Bus\Application;

interface QueryResponse
{
    public function toArray(): array;
}