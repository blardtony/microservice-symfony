<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Product;

interface PromotionEnquiryInterface
{
    public function getProduct(): ?Product;

    public function setPromotionId(int $promotionId);

    public function setPromotionName(string $promotionName);
}