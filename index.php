#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use CoffeeManager\Infrastructure\Console\MakeDrinkConsoleCommand;
use CoffeeManager\Infrastructure\Console\ShowOrdersCommand;
use CoffeeManager\Infrastructure\Console\ShowOrdersByDrinkTypeCommand;
use CoffeeManager\Infrastructure\Persistence\MySql\OrderRepositoryMySql;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new MakeDrinkConsoleCommand());
$application->add(new ShowOrdersCommand(OrderRepositoryMySql::build()));
$application->add(new ShowOrdersByDrinkTypeCommand(OrderRepositoryMySql::build()));

$application->run();
