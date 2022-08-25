<?php

declare(strict_types=1);

namespace App\DTO;

interface PriceEnquiryInterface extends PromotionEnquiryInterface
{
    public function setPrice(int $price);

    public function setDiscountedPrice(float $discountedPrice);

    public function getQuantity(): ?int;
}