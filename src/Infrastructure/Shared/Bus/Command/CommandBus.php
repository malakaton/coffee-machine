<?php

namespace Deliverea\CoffeeMachine\Infrastructure\Shared\Bus\Command;

use Deliverea\CoffeeMachine\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class CommandBus
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    private int $commandStatus;

    /**
     * CommandBus constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param CommandInterface $command
     * @throws Throwable
     */
    public function handle(CommandInterface $command): void
    {
        try {
            $envelope = $this->messageBus->dispatch($command);

            $this->commandStatus = $envelope->last(HandledStamp::class)->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }

    public function getCommandStatus(): int
    {
        return $this->commandStatus;
    }
}
