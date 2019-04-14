<?php

namespace App\Repository;

use App\Entity\ProductGlobal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductGlobal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductGlobal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductGlobal[]    findAll()
 * @method ProductGlobal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductGlobalRepository extends ServiceEntityRepository
{
    /**
     * ProductRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductGlobal::class);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function truncateTabale(): void
    {
        $sqlTruncate = 'TRUNCATE `product_global`';
        $result = $this->getEntityManager()->getConnection()->prepare($sqlTruncate);
        $result->execute();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function copyProductTabale(): void
    {
        $sqlTruncate = 'INSERT `product_global` SELECT * FROM `product`';
        $result = $this->getEntityManager()->getConnection()->prepare($sqlTruncate);
        $result->execute();
    }
}
