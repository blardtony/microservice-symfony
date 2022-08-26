<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\DTO\DtoCreateEvent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DtoEventSubscriber implements EventSubscriberInterface
{

    #[ArrayShape([DtoCreateEvent::class => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            DtoCreateEvent::class => 'onCreate'
        ];
    }

    public function onCreate(DtoCreateEvent $event)
    {
        
    }
}