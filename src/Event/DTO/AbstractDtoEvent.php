<?php

declare(strict_types=1);

namespace App\Event\DTO;

use App\DTO\PromotionEnquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractDtoEvent extends Event
{

    public function __construct(private PromotionEnquiryInterface $dto)
    {
    }

    /**
     * @return PromotionEnquiryInterface
     */
    public function getDto(): PromotionEnquiryInterface
    {
        return $this->dto;
    }
}