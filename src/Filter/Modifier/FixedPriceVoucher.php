<?php

declare(strict_types=1);

namespace App\Filter\Modifier;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class FixedPriceVoucher implements PriceModifierInterface
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
        $total = $price * $quantity;
        if ($enquiry->getVoucherCode() === $promotion->getCriteria()['code']) {
            return $promotion->getAdjustment() * $quantity;
        }
        return $total;
    }
}