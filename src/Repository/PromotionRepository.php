<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Promotion;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @extends ServiceEntityRepository<Promotion>
 *
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private CacheInterface $cache)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function add(Promotion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Promotion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findValidForProduct(Product $product, DateTimeInterface $requestDate)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.productPromotions', 'pp')
            ->andWhere('pp.product = :product')
            ->andWhere('pp.validTo > :requestDate OR pp.validTo IS NULL')
            ->setParameter('product', $product)
            ->setParameter('requestDate', $requestDate)
            ->getQuery()
            ->getResult();
    }
}
