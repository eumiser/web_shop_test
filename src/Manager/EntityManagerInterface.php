<?php

namespace App\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Interface EntityManagerInterface
 */
interface EntityManagerInterface
{
    /**
     * Finds one entity by id
     *
     * @param $id
     *
     * @return mixed
     */
    public function findOneById(int $id);

    /**
     * Finds one entity by the given criteria
     *
     * @param array $criteria
     *
     * @return mixed
     */
    public function findOneBy(array $criteria);

    /**
     * Finds all entities.
     *
     * @return Collection
     */
    public function findAll(): array;

    /**
     * Finds entities by the given criteria
     *
     * @param array $criteria
     *
     * @return Collection
     */
    public function findBy(array $criteria);

    /**
     * Creates an empty entity instance
     *
     * @return mixed
     */
    public function create();

    /**
     * Saves a entity
     *
     * @param mixed $entity
     *
     * @return mixed
     */
    public function save($entity);

    /**
     * Save collection entities
     *
     * @param ArrayCollection $products
     *
     * @return mixed
     */
    public function saveCollection(ArrayCollection $products);

    /**
     * Remove a entity
     *
     * @param $entity
     *
     * @return mixed
     */
    public function remove($entity);
}
