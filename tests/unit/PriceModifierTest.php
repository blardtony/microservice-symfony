<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\LowestPriceFilter;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Tests\ServiceTestCase;

class PriceModifierTest extends ServiceTestCase
{
    public function testDateRangeMultiplierReturnCorrectlyModifiedPrice()
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setRequestDate("2022-11-27");
        $promotion = (new Promotion())->setName('Black Friday half price sale')
            ->setAdjustment(0.5)
            ->setCriteria(["form" => "2022-11-25", "to" => "2022-11-28"])
            ->setType("date_range_multiplier");
        $dateRangeModifier = new DateRangeMultiplier();

        $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);

        $this->assertEquals(250, $modifiedPrice);
    }

    public function testFixedVoucherReturnCorrectlyModifiedPrice()
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode('OU812');

        $promotion = (new Promotion())->setName('Voucher OU812')
            ->setAdjustment(100)
            ->setCriteria(["code" => "OA812"])
            ->setType("fixed_price_voucher");

        $fixedPriceVoucher = new FixedPriceVoucher();
        $modifiedPrice = $fixedPriceVoucher->modify(100, 5, $promotion, $enquiry);

        $this->assertEquals(500, $modifiedPrice);
    }


//    private function promotionsDataProvider(): array
//    {
//        $promotionOne = (new Promotion())->setName('Black Friday half price sale')
//            ->setAdjustment(0.5)
//            ->setCriteria(["form" => "2022-11-25", "to" => "2022-11-28"])
//            ->setType("date_range_multiplier");
//
//        $promotionTwo = (new Promotion())->setName('Voucher OU812')
//            ->setAdjustment(100)
//            ->setCriteria(["code" => "OU812"])
//            ->setType("fixed_price_voucher");
//
//        $promotionThree = (new Promotion())->setName('Buy one get one free')
//            ->setAdjustment(0.5)
//            ->setCriteria(["minimum_quantity" => "2"])
//            ->setType("even_items_multiplier");
//
//        return [$promotionOne, $promotionTwo, $promotionThree];
//    }

}