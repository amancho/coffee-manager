<?php

namespace App\CoffeeManager\Infrastructure\Console;

use App\CoffeeManager\Application\Command\Drink\MakeDrinkCommand;
use App\CoffeeManager\Application\Command\Drink\MakeDrinkCommandHandler;
use App\CoffeeManager\Application\Command\Order\StoreOrderCommand;
use App\CoffeeManager\Application\Command\Order\StoreOrderCommandHandler;
use App\CoffeeManager\Domain\Drink\DrinkService;
use App\CoffeeManager\Infrastructure\Persistence\MySql\OrderRepositoryMySql;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDrinkConsoleCommand extends Command
{
    public function __construct(private readonly CommandBus $commandBus)
    {
        parent::__construct('app:order-drink');
    }

    protected function configure(): void
    {
        $this->addArgument(
            'drink-type',
            InputArgument::REQUIRED,
            'The type of the drink. (Tea, Coffee or Chocolate)'
        );

        $this->addArgument(
            'money',
            InputArgument::REQUIRED,
            'The amount of money given by the user'
        );

        $this->addArgument(
            'sugars',
            InputArgument::OPTIONAL,
            'The number of sugars you want. (0, 1, 2)',
            0
        );

        $this->addOption(
            'extra-hot',
            'extra',
            InputOption::VALUE_NONE,
            $description = 'If the user wants to make the drink extra hot'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {

            $makeDrinkCommand = MakeDrinkCommand::create(
                strtolower($input->getArgument('drink-type')),
                (float) $input->getArgument('money'),
                (int) $input->getArgument('sugars'),
                boolval($input->getOption('extra-hot'))
            );

            $makeDrinkCommandHandler = new MakeDrinkCommandHandler(new DrinkService());
            $output->writeln($makeDrinkCommandHandler->handle($makeDrinkCommand));

            $this->commandBus->handle(
                StoreOrderCommand::create(
                    $makeDrinkCommand->type(),
                    $makeDrinkCommand->sugars(),
                    $makeDrinkCommand->extraHot(),
                )
            );

        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}