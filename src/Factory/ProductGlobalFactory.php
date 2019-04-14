<?php


namespace App\Factory;

use App\Entity\Product;
use App\Entity\ProductGlobal;
use App\Manager\ProductGlobalManager;
use App\Model\ProductGlobalFactoryResponse;
use App\Model\ProductXml;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ProductGlobalFactory
 * @package App\Factory
 */
class ProductGlobalFactory
{
    /**
     * @var ProductGlobalManager
     */
    private $productGlobalManager;

    private $translator;

    /**
     * ProductGlobalFactory constructor.
     *
     * @param ProductGlobalManager $productManager
     * @param TranslatorInterface  $translator
     */
    public function __construct(ProductGlobalManager $productManager, TranslatorInterface $translator)
    {
        $this->productGlobalManager = $productManager;
        $this->translator = $translator;
    }

    /**
     * @param array|Product[] $products
     *
     * @return ProductGlobalFactoryResponse
     * @throws \Exception
     */
    public function getProductsGlobalFromDB(array $products): ProductGlobalFactoryResponse
    {
        $productGlobalFactoryResponse = new ProductGlobalFactoryResponse();

        foreach ($products as $product) {
            $productGlobalFactoryResponse->addProductGlobal($this->getNewProductGlobalFromProductDB($product));
        }

        return $productGlobalFactoryResponse;
    }

    /**
     * @param Product $product
     *
     * @return ProductGlobal
     * @throws \Exception
     */
    private function getNewProductGlobalFromProductDB(Product $product): ProductGlobal
    {
        $newProductGlobal = $this->productGlobalManager->create();

        $newProductGlobal->setId($product->getId());
        $newProductGlobal->setReference($product->getReference());
        $newProductGlobal->setTitle($product->getTitle());
        $newProductGlobal->setDescription($product->getDescription());
        $newProductGlobal->setPrice($product->getPrice());
        $newProductGlobal->setImageLink($product->getImageLink());

        return $newProductGlobal;
    }

    /**
     * @param array|ProductXml[] $productsXml
     *
     * @return ProductGlobalFactoryResponse
     */
    public function getProductsGlobalFromProductsXml(array $productsXml): ProductGlobalFactoryResponse
    {
        $productGlobalFactoryResponse = new ProductGlobalFactoryResponse();

        foreach ($productsXml as $productXml) {
            try {
                $productGlobalFactoryResponse->addProductGlobal($this->getNewProductGlobalFromProductXml($productXml));
            } catch (\Exception $exception) {
                $productGlobalFactoryResponse->addError("{$this->translator->trans('error.in_line')} {$productXml['line_row']}: {$exception->getMessage()}");
            }
        }

        return $productGlobalFactoryResponse;
    }

    /**
     * @param ProductXml $productXml
     *
     * @return ProductGlobal
     * @throws \Exception
     */
    private function getNewProductGlobalFromProductXml(ProductXml $productXml): ProductGlobal
    {
        $newProductGlobal = $this->productGlobalManager->create();

        $description = $productXml->getDescription();
        if (empty($description)) {
            $description = '';
        }

        $newProductGlobal->setReference($productXml->getReference());
        $newProductGlobal->setTitle($productXml->getTitle());
        $newProductGlobal->setDescription($description);
        $newProductGlobal->setPrice($productXml->getPrice());
        $newProductGlobal->setImageLink($productXml->getImageLink());

        return $newProductGlobal;
    }
}