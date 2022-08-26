<?php

declare(strict_types=1);

namespace App\Event\DTO;

use App\DTO\PromotionEnquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractDtoEvent extends Event
{

    public function __construct(private PromotionEnquiryInterface $enquiry)
    {
    }

    /**
     * @return PromotionEnquiryInterface
     */
    public function getEnquiry(): PromotionEnquiryInterface
    {
        return $this->enquiry;
    }
}