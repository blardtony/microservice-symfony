<?php

declare(strict_types=1);

namespace App\Cache;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Repository\PromotionRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class PromotionCache
{

    public function __construct(private CacheInterface $cache, private readonly PromotionRepository $promotionRepository)
    {
    }

    public function findValidForProduct(Product $product, string $requestDate): ?array
    {
        $key = sprintf("find_valid_for_product_%d", $product->getId());
        return $this->cache->get($key, function (ItemInterface $item) use ($requestDate, $product) {
            return $this->promotionRepository->findValidForProduct($product, date_create_immutable($requestDate));
        });
    }


}