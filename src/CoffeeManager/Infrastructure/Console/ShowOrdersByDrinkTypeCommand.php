<?php

namespace CoffeeManager\Infrastructure\Console;

use CoffeeManager\Application\Query\Order\GetDrinkTypeStats\GetDrinkTypeStats;
use CoffeeManager\Application\Query\Order\GetDrinkTypeStats\GetDrinkTypeStatsQuery;
use CoffeeManager\Application\Query\Order\GetDrinkTypeStats\GetDrinkTypeStatsResponse;
use CoffeeManager\Domain\Order\OrderRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShowOrdersByDrinkTypeCommand extends Command
{
    protected static $defaultName = 'app:show-orders-amount-by-drink';

    public function __construct(private readonly OrderRepository $orderRepository)
    {
        parent::__construct(ShowOrdersByDrinkTypeCommand::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $getDrinkTypesStatsQuery = new GetDrinkTypeStats($this->orderRepository);

            /** @var  $getOrdersResponse GetDrinkTypeStatsResponse */
            $getDrinkTypeStatsResponse= $getDrinkTypesStatsQuery->handle(new GetDrinkTypeStatsQuery());

            $output->write($getDrinkTypeStatsResponse->report());
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}