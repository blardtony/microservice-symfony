<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    public function testLowestPricePromotionsFilteringIsAppliedCorrectly()
    {
        $product = new Product();
        $product->setPrice(100);

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setProduct($product);
        $enquiry->setQuantity(5);
        $promotions = $this->promotionsDataProvider();

        $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

        $filteredEnquiry = $lowestPriceFilter->apply($enquiry, ...$promotions);
//        dd($filteredEnquiry);
        $this->assertSame(100, $filteredEnquiry->getPrice());
        $this->assertSame(250, $filteredEnquiry->getDiscountedPrice());
        $this->assertSame('Black Friday half price sale', $filteredEnquiry->getPromotionName());
    }


    private function promotionsDataProvider(): array
    {
        $promotionOne = (new Promotion())->setName('Black Friday half price sale')
            ->setAdjustment(0.5)
            ->setCriteria(["form" => "2022-11-25", "to" => "2022-11-28"])
            ->setType("date_range_multiplier");

        $promotionTwo = (new Promotion())->setName('Voucher OU812')
            ->setAdjustment(100)
            ->setCriteria(["code" => "OU812"])
            ->setType("fixed_price_voucher");

        $promotionThree = (new Promotion())->setName('Buy one get one free')
            ->setAdjustment(0.5)
            ->setCriteria(["minimum_quantity" => "2"])
            ->setType("even_items_multiplier");

        return [$promotionOne, $promotionTwo, $promotionThree];
    }

}