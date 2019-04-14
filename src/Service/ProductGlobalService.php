<?php

namespace App\Service;

use App\Factory\ProductGlobalFactory;
use App\Manager\ProductGlobalManager;

/**
 * Class ProductGlobalService
 * @package App\Service
 */
class ProductGlobalService
{
    public const XML_TYPE = 'xml';
    public const JSON_TYPE = 'json';

    /** @var ProductGlobalManager */
    private $productGlobalManager;

    /** @var ProductGlobalFactory */
    private $productGlobalFactory;

    /** @var ProductImportService */
    private $productImportService;

    /**
     * ProductGlobalService constructor.
     *
     * @param ProductGlobalManager $productGlobalManager
     * @param ProductGlobalFactory $productGlobalFactory
     * @param ProductImportService $productImportService
     */
    public function __construct(
        ProductGlobalManager $productGlobalManager,
        ProductGlobalFactory $productGlobalFactory,
        ProductImportService $productImportService
    ) {
        $this->productGlobalManager = $productGlobalManager;
        $this->productGlobalFactory = $productGlobalFactory;
        $this->productImportService = $productImportService;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function refresh(): void
    {
        $this->productGlobalManager->resetTable();

        $productsFromXml = $this->productImportService->findProductsFromXmlDir();

        $globalFactoryResponse = $this->productGlobalFactory->getProductsGlobalFromProductsXml($productsFromXml);

        $this->productGlobalManager->saveCollection($globalFactoryResponse->getProductsGlobalCollection());
    }
}