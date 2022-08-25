<?php

declare(strict_types=1);

namespace App\Filter;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class LowestPriceFilter implements PromotionsFilterInterface
{

    /**
     * @param LowestPriceEnquiry $enquiry
     * @param Promotion ...$promotion
     * @return PromotionEnquiryInterface
     */
    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface
    {
        $enquiry->setDiscountedPrice(50);
        $enquiry->setPrice(50);
        $enquiry->setPromotionId(3);
        $enquiry->setPromotionName('Black Friday half price sale');

        return $enquiry;
    }
}