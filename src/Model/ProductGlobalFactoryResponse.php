<?php

namespace App\Model;

use App\Entity\ProductGlobal;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ProductGlobalFactoryResponse
 */
class ProductGlobalFactoryResponse
{
    /** @var ArrayCollection|ProductGlobal[] */
    private $productsCollection;

    /** @var ArrayCollection|ErrorMessage[] */
    private $errors;

    /**
     * ProductGlobalFactoryResponse constructor.
     */
    public function __construct()
    {
        $this->productsCollection = new ArrayCollection();
        $this->errors = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|ProductGlobal[]
     */
    public function getProductsGlobalCollection()
    {
        return $this->productsCollection;
    }

    /**
     * @param ArrayCollection $productsCollection
     *
     * @return ProductGlobalFactoryResponse
     */
    public function setProductsGlobalCollection(ArrayCollection $productsCollection): ProductGlobalFactoryResponse
    {
        $this->productsCollection = $productsCollection;
        return $this;
    }

    /**
     * @param ProductGlobal $product
     *
     * @return ProductGlobalFactoryResponse
     */
    public function addProductGlobal(ProductGlobal $product): ProductGlobalFactoryResponse
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
     * @return ProductGlobalFactoryResponse
     */
    public function setErrors(array $errors): ProductGlobalFactoryResponse
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param string $error
     *
     * @return $this
     */
    public function addError(string $error): ProductGlobalFactoryResponse
    {
        $this->errors->add($error);

        return $this;
    }
}