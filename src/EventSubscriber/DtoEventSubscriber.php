<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\DTO\DtoCreateEvent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoEventSubscriber implements EventSubscriberInterface
{


    public function __construct(private ValidatorInterface $validator)
    {
    }

    #[ArrayShape([DtoCreateEvent::class => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            DtoCreateEvent::class => 'onCreate'
        ];
    }

    public function onCreate(DtoCreateEvent $event)
    {
        $dto = $event->getDto();

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new ValidationFailedException('Validation failed', $errors);
        }
    }
}