<?php

namespace App\Model;

use App\Model\ProductXml;

/**
 * Class ProductsXml
 * @package App\Model
 */
class ProductsXml extends ProductXml
{
    /** @var ProductXml[] */
    private $item;

    /**
     * @return ProductXml[]
     */
    public function getItem(): array
    {
        return $this->item;
    }

    /**
     * @param ProductXml[] $item
     *
     * @return ProductsXml
     */
    public function setItem(array $item): ProductsXml
    {
        $this->item = $item;
        return $this;
    }
}