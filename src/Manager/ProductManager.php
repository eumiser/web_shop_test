<?php

namespace App\Manager;

use App\Entity\Product;
use App\Manager\EntityManagerInterface as EntityManagerInterfaceBase;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class ProductManager
 */
class ProductManager implements EntityManagerInterfaceBase
{
    /** @var EntityManager */
    private $entityManager;

    /** @var ProductRepository */
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
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    /**
     * @param int $id
     *
     * @return Product|null|object
     */
    public function findOneById(int $id): ?Product
    {
        return $this->repository->find($id);
    }

    /**
     * Finds one product by the given criteria
     *
     * @param array $criteria
     *
     * @return Product|null|object
     */
    public function findOneBy(array $criteria): ?Product
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Finds Users by the given criteria
     *
     * @param array $criteria
     *
     * @return Product[]
     */
    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Finds all Product.
     *
     * @return Product[]|Collection
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return Product
     */
    public function create(): Product
    {
        return new Product();
    }

    /**
     * @param Product $product
     *
     * @return Product
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($product): Product
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->refresh($product);

        return $product;
    }

    /**
     * Save collection entities
     *
     * @param ArrayCollection $products
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveCollection(ArrayCollection $products)
    {
        foreach ($products as $product) {
            $this->save($product);
        }
    }

    /**
     * @param $product
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function remove($product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    /**
     * @param int $higher
     * @param int $lower
     *
     * @return mixed|Product[]
     */
    public function findByIdsBetween(int $higher, int $lower)
    {
        return $this->repository->findByIdsBetween($higher, $lower);
    }
}