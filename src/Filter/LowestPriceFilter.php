<?php

declare(strict_types=1);

namespace App\Filter;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;
use App\Filter\Modifier\Factory\PriceModifierFactoryInterface;

class LowestPriceFilter implements PromotionsFilterInterface
{
    public function __construct(private readonly PriceModifierFactoryInterface $priceModifierFactory)
    {
    }


    /**
     * @param LowestPriceEnquiry $enquiry
     * @param Promotion ...$promotions
     * @return PromotionEnquiryInterface
     */
    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotions): PromotionEnquiryInterface
    {

        $price = $enquiry->getProduct()->getPrice();
        $quantity = $enquiry->getQuantity();
        $lowestPrice = $quantity * $price;

        foreach ($promotions as $promotion) {

            $priceModifier = $this->priceModifierFactory->create($promotion->getType());
//            dd($priceModifier);
            $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $enquiry);
        }
//        $priceModifier = ;
        $enquiry->setDiscountedPrice(250);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(3);
        $enquiry->setPromotionName('Black Friday half price sale');

        return $enquiry;
    }
}