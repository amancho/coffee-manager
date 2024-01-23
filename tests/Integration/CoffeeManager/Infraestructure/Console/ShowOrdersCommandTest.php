<?php

namespace CoffeeManager\Tests\Integration\Infraestructure\Console;

use CoffeeManager\Domain\Drink\Drink;
use CoffeeManager\Domain\Order\Order;
use CoffeeManager\Domain\Order\OrderCollection;
use CoffeeManager\Domain\Order\OrderRepository;
use CoffeeManager\Infrastructure\Console\ShowOrdersCommand;
use CoffeeManager\Shared\Domain\InvalidCollectionObjectException;
use Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ShowOrdersCommandTest extends IntegrationTestCase
{
    /** @var OrderRepository&MockObject  */
    private mixed $repository;
    private Command $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(OrderRepository::class);
        $this->application->add(new ShowOrdersCommand($this->repository));
        $this->command = $this->application->find('app:show-orders');
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public function test_show_orders_returns_the_expected_output(): void
    {
        $orderCollection = OrderCollection::create($this->getOrders());

        $this->repository
            ->expects(self::once())
            ->method('getAll')
            ->willReturn($orderCollection);

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command'  => $this->command->getName()]);

        $expectedOutput = "Drink      | Price | Sugar   | Stick   | E.Hot
------------------------------------------- 
chocolate  | 0.6€  | 0       |         |        
tea        | 0.4€  | 1       | 1       |        
coffee     | 0.5€  | 2       | 1       |        
";

    $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function test_show_orders_throws_exception(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getAll')
            ->willThrowException(new InvalidCollectionObjectException(Drink::build(1, 'tea'), Order::class));

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command'  => $this->command->getName()]);

        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
    }

    private function getOrders(): array
    {
        return [
            Order::buildBasic('chocolate', 0),
            Order::buildBasic('tea', 1),
            Order::buildBasic('coffee', 2),
        ];
    }
}
