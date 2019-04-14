<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductGlobalRepository")
 */
class ProductGlobal
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageLink;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ProductGlobal
     */
    public function setId(int $id): ProductGlobal
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getReference(): int
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     *
     * @return ProductGlobal
     */
    public function setReference(int $reference): ProductGlobal
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
     * @return ProductGlobal
     */
    public function setTitle(string $title): ProductGlobal
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return ProductGlobal
     */
    public function setDescription(string $description): ProductGlobal
    {
        $this->description = $description;

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
     * @return ProductGlobal
     */
    public function setImageLink(string $imageLink): ProductGlobal
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return ProductGlobal
     */
    public function setPrice(float $price): ProductGlobal
    {
        $this->price = $price;

        return $this;
    }
}
