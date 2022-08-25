<?php

namespace App\Controller;

use App\Cache\PromotionCache;
use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\PromotionsFilterInterface;
use App\Repository\ProductRepository;
use App\Repository\PromotionRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{


    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    #[Route('/{id}/lowest-price', name: 'lowest-price', methods: ['POST'])]
    public function lowestPrice(Request $request, int $id, DTOSerializer $serializer, PromotionsFilterInterface $promotionsFilter, CacheInterface $cache, PromotionCache $promotionCache): Response
    {
        if ($request->headers->has('force-fail')) {
            return new JsonResponse(
                [
                    'error' => 'Promotions Engine failure message'
                ],
                $request->headers->get('force_fail')
            );
        }

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

        $product = $this->productRepository->find($id);

        $lowestPriceEnquiry->setProduct($product);

        $promotions = $promotionCache->findValidForProduct($product, $lowestPriceEnquiry->getRequestDate());
//        dd($promotions);
        $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry, ...$promotions);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

        return new Response(
            $responseContent,
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
