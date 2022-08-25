<?php

declare(strict_types=1);

namespace App\Filter\Modifier;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class DateRangeMultiplier implements PriceModifierInterface
{

    /**
     * @param int $price
     * @param int $quantity
     * @param Promotion $promotion
     * @param LowestPriceEnquiry $enquiry
     * @return float
     */
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): float
    {
        $requestDate = date_create($enquiry->getRequestDate());
        $from = date_create($promotion->getCriteria()['form']);
        $to = date_create($promotion->getCriteria()['to']);
        $total = $price * $quantity;

        if ($requestDate >= $from && $requestDate <= $to) {
            return $total * $promotion->getAdjustment();
        }
        return $total;
    }
}