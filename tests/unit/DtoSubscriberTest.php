<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\DTO\DtoCreateEvent;
use App\Tests\ServiceTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DtoSubscriberTest extends ServiceTestCase
{
    public function testDtoIsValidatedAfterCreated()
    {
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);

        $event = new DtoCreateEvent($dto);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');
        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('This value should be positive.');
        $eventDispatcher->dispatch($event);

    }

}