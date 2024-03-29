<?php

namespace CoffeeManager\Tests\Integration\Infraestructure\Console;

use App\CoffeeManager\Domain\Order\OrderRepository;
use App\CoffeeManager\Infrastructure\Console\MakeDrinkConsoleCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use CoffeeManager\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MakeDrinkConsoleCommandTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $commandBus = $this->createMock(CommandBus::class);
        $this->application->add(new MakeDrinkConsoleCommand($commandBus));
    }

    /**
     * @dataProvider ordersProvider
     * @param string $drinkType
     * @param string $money
     * @param int $sugars
     * @param string $extraHot
     * @param string $expectedOutput
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        string $money,
        int $sugars,
        string $extraHot,
        string $expectedOutput
    ): void {
        $command = $this->application->find('app:order-drink');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
            '--extra-hot' => $extraHot
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'chocolate', '0.7', 1, '', 'You have ordered a chocolate with 1 sugars (stick included)' . PHP_EOL
            ],
            [
                'tea', '0.4', 0, '1', 'You have ordered a tea extra hot' . PHP_EOL
            ],
            [
                'coffee', '2', 2, '1', 'You have ordered a coffee extra hot with 2 sugars (stick included)' . PHP_EOL
            ],
            [
                'coffee', '0.2', 2, '1', 'The coffee costs 0.5.' . PHP_EOL
            ],
            [
                'chocolate', '0.3', 2, '1', 'The chocolate costs 0.6.' . PHP_EOL
            ],
            [
                'tea', '0.1', 2, '1', 'The tea costs 0.4.' . PHP_EOL
            ],
            [
                'tea', '0.5', -1, '1', 'The number of sugars should be between 0 and 2.' . PHP_EOL
            ],
            [
                'tea', '0.5', 3, '1', 'The number of sugars should be between 0 and 2.' . PHP_EOL
            ],
        ];
    }
}
