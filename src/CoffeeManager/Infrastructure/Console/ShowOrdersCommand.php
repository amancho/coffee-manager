<?php

namespace CoffeeManager\Infrastructure\Console;

use CoffeeManager\Application\Query\Order\GetOrders\GetOrders;
use CoffeeManager\Application\Query\Order\GetOrders\GetOrdersQuery;
use CoffeeManager\Application\Query\Order\GetOrders\GetOrdersResponse;
use CoffeeManager\Domain\Order\OrderRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShowOrdersCommand extends Command
{
    protected static $defaultName = 'app:show-orders';

    public function __construct(private readonly OrderRepository $orderRepository)
    {
        parent::__construct(ShowOrdersCommand::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $getOrdersQuery = new GetOrders($this->orderRepository);

            /** @var  $getOrdersResponse GetOrdersResponse */
            $getOrdersResponse = $getOrdersQuery->handle(new GetOrdersQuery());

            $output->write($getOrdersResponse->report());
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}