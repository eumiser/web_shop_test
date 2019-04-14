<?php

namespace App\Manager;

use App\Entity\ProductGlobal;
use App\Manager\EntityManagerInterface as EntityManagerInterfaceBase;
use App\Repository\ProductGlobalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class ProductGlobalManager
 */
class ProductGlobalManager implements EntityManagerInterfaceBase
{
    /** @var EntityManager */
    private $entityManager;

    /** @var ProductGlobalRepository */
    private $repository;

    /**
     * DispatcherService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ProductGlobal::class);
    }

    /**
     * @param int $id
     *
     * @return ProductGlobal|null|object
     */
    public function findOneById(int $id): ?ProductGlobal
    {
        return $this->repository->find($id);
    }

    /**
     * Finds one productGlobal by the given criteria
     *
     * @param array $criteria
     *
     * @return ProductGlobal|null|object
     */
    public function findOneBy(array $criteria): ?ProductGlobal
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Finds Users by the given criteria
     *
     * @param array $criteria
     *
     * @return ProductGlobal[]
     */
    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Finds all ProductGlobal.
     *
     * @return ProductGlobal[]|Collection
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return ProductGlobal
     */
    public function create(): ProductGlobal
    {
        return new ProductGlobal();
    }

    /**
     * @param ProductGlobal $productGlobal
     *
     * @return ProductGlobal
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($productGlobal): ProductGlobal
    {
        $this->entityManager->persist($productGlobal);
        $this->entityManager->flush();
        $this->entityManager->refresh($productGlobal);

        return $productGlobal;
    }

    /**
     * Save collection entities
     *
     * @param ArrayCollection $productGlobals
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveCollection(ArrayCollection $productGlobals)
    {
        foreach ($productGlobals as $productGlobal) {
            $this->save($productGlobal);
        }
    }

    /**
     * @param $productGlobal
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function remove($productGlobal)
    {
        $this->entityManager->remove($productGlobal);
        $this->entityManager->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeAll(): void
    {
        $productsGlobal = $this->findAll();

        foreach ($productsGlobal as $productGlobal) {
            $this->remove($productGlobal);
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function resetTable()
    {
        $this->repository->truncateTabale();

        $this->repository->copyProductTabale();
    }
}