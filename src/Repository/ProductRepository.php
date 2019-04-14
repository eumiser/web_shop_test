<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * ProductRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param int $higher
     * @param int $lower
     *
     * @return mixed
     */
    public function findByIdsBetween(int $higher, int $lower)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id >= :idLower')
            ->andWhere('p.id <= :idHigher')
            ->setParameter('idHigher', $higher)
            ->setParameter('idLower', $lower)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
