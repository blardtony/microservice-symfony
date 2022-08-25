<?php

declare(strict_types=1);

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class EvenItemMultiplier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): float
    {
        if ($quantity >= 2) {
            $oddCount = $quantity % 2;
            $evenCount = $quantity - $oddCount;

            return $evenCount * $price * $promotion->getAdjustment() + $oddCount * $price;
        }
        return $price * $quantity;
    }
}