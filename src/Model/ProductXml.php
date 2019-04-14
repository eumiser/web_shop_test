<?php

namespace App\Model;

/**
 * Class ProductXml
 */
class ProductXml
{
    /** @var string */
    private $id;

    /** @var string */
    private $reference;

    /** @var string */
    private $title;

    /** @var array|string */
    private $description;

    /** @var string */
    private $price;

    /** @var string */
    private $imageLink;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return ProductXml
     */
    public function setId(string $id): ProductXml
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return ProductXml
     */
    public function setReference(string $reference): ProductXml
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return ProductXml
     */
    public function setTitle(string $title): ProductXml
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param array|string $description
     *
     * @return ProductXml
     */
    public function setDescription($description): ProductXml
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     *
     * @return ProductXml
     */
    public function setPrice(string $price): ProductXml
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    /**
     * @param string $imageLink
     *
     * @return ProductXml
     */
    public function setImageLink(string $imageLink): ProductXml
    {
        $this->imageLink = $imageLink;
        return $this;
    }
}