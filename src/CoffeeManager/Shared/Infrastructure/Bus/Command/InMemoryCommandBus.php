<?php

declare(strict_types=1);

namespace CoffeeManager\Shared\Infrastructure\Bus\Command;

use CoffeeManager\Shared\Bus\Application\Command;
use CoffeeManager\Shared\Bus\Domain\CommandBus;
use CoffeeManager\Shared\Infrastructure\Bus\HandlerBuilder;
use InvalidArgumentException;
use ReflectionException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Throwable;

final class InMemoryCommandBus implements CommandBus
{
    private MessageBus $bus;

    /**
     * @throws ReflectionException
     */
    public function __construct(
        iterable $commandHandlers
    ) {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($commandHandlers),
                ),
            ),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function handle(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException $e) {
            throw new InvalidArgumentException(sprintf('The command has not a valid handler: %s', $command::class));
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}