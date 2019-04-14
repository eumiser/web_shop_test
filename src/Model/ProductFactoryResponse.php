<?php

namespace App\Model;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ProductFactoryResponse
 */
class ProductFactoryResponse
{
    /** @var ArrayCollection|Product[] */
    private $productsCollection;

    /** @var ArrayCollection|ErrorMessage[] */
    private $errors;

    /**
     * ProductFactoryResponse constructor.
     */
    public function __construct()
    {
        $this->productsCollection = new ArrayCollection();
        $this->errors = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Product[]
     */
    public function getProductsCollection()
    {
        return $this->productsCollection;
    }

    /**
     * @param ArrayCollection $productsCollection
     *
     * @return ProductFactoryResponse
     */
    public function setProductsCollection(ArrayCollection $productsCollection): ProductFactoryResponse
    {
        $this->productsCollection = $productsCollection;
        return $this;
    }

    /**
     * @param Product $product
     *
     * @return ProductFactoryResponse
     */
    public function addProduct(Product $product): ProductFactoryResponse
    {
        if ($this->productsCollection->contains($product)) {
            return $this;
        }

        $this->productsCollection->add($product);

        return $this;
    }

    /**
     * @return ErrorMessage[]|ArrayCollection
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ErrorMessage[] $errors
     *
     * @return ProductFactoryResponse
     */
    public function setErrors(array $errors): ProductFactoryResponse
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param string $error
     *
     * @return $this
     */
    public function addError(string $error): ProductFactoryResponse
    {
        $this->errors->add($error);

        return $this;
    }
}