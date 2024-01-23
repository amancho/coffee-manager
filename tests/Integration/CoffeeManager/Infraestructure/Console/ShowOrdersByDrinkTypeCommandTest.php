<?php

namespace CoffeeManager\Tests\Integration\Infraestructure\Console;

use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Infrastructure\Console\ShowOrdersByDrinkTypeCommand;
use Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ShowOrdersByDrinkTypeCommandTest extends IntegrationTestCase
{
    /** @var OrderRepository&MockObject  */
    private mixed $repository;
    private Command $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(OrderRepository::class);
        $this->application->add(new ShowOrdersByDrinkTypeCommand($this->repository));
        $this->command = $this->application->find('app:show-orders-amount-by-drink');
    }

    public function test_show_orders_by_drink_returns_the_expected_output(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getOrdersMoneyByType')
            ->willReturn([
                    [ 'drink_type' => 'coffee', 'amount' => 3.013 ],
                    [ 'drink_type' => 'tea', 'amount' =>  2.014],
                    [ 'drink_type' => 'chocolate', 'amount' =>  11.720 ]
                ]
            );

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command'  => $this->command->getName()]);

        $expectedOutput = "| Drink Type | Amount |\n|------------|--------| \ncoffee       | 3.01€  | \ntea          | 2.01€  | \nchocolate    | 11.72€ | \n";

        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function test_show_orders_by_drink_throws_exception(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getOrdersMoneyByType')
            ->willThrowException(new \Exception());

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command'  => $this->command->getName()]);

        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
    }
}
