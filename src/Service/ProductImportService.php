<?php

namespace App\Service;

use App\Factory\ProductFactory;
use App\Manager\ProductManager;
use App\Model\ProductFactoryResponse;
use App\Model\ProductsXml;
use App\Service\File\DirectoryService;
use App\Service\File\SheetService;
use App\Service\File\SystemService;
use Box\Spout\Common\Type;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class LanguageService
 * @package App\Service
 */
class ProductImportService
{
    public const XML_TYPE = 'xml';
    public const JSON_TYPE = 'json';

    /** @var ProductManager */
    private $productManager;

    /** @var ProductFactory */
    private $productFactory;

    /** @var TranslatorInterface */
    private $translator;

    /** @var DirectoryService */
    private $directoryService;

    /** @var SystemService */
    private $systemService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * ProductImportService constructor.
     *
     * @param ProductManager      $productManager
     * @param TranslatorInterface $translator
     * @param ProductFactory      $productFactory
     * @param DirectoryService    $directoryService
     * @param SystemService       $systemService
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ProductManager $productManager,
        TranslatorInterface $translator,
        ProductFactory $productFactory,
        DirectoryService $directoryService,
        SystemService $systemService,
        SerializerInterface $serializer
    ) {
        $this->productManager = $productManager;
        $this->translator = $translator;
        $this->productFactory = $productFactory;
        $this->directoryService = $directoryService;
        $this->systemService = $systemService;
        $this->serializer = $serializer;
    }

    /**
     * @param array $rowData
     *
     * @return bool
     */
    public function validTranslationsExcelHeaders(array $rowData): bool
    {
        $requiredHeaders = [
            'id',
            'manufacturer',
            'name',
            'additional',
            'price',
            'product_image',
        ];

        foreach ($requiredHeaders as $requiredHeader) {
            if (!isset($rowData[$requiredHeader])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $filePath
     * @param bool   $overwrite
     *
     * @return ProductFactoryResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function loadProductsFromExcelFile(string $filePath, bool $overwrite = false): ProductFactoryResponse
    {
        try {
            $rowsData = SheetService::readExcelFile(Type::CSV, $filePath);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException(
                $this->translator->trans('form.read_csv_file_error')
            );
        }

        if (!$this->validTranslationsExcelHeaders($rowsData[0])) {
            throw new \InvalidArgumentException(
                $this->translator->trans('form.required_headers_missing_csv')
            );
        }

        $productFactoryResponse = $this->productFactory->getProductsFromCsvData($rowsData);

        if ($overwrite) {
            $this->productManager->saveCollection($productFactoryResponse->getProductsCollection());
            return $productFactoryResponse;
        }

        foreach ($productFactoryResponse->getProductsCollection() as $product) {
            if (!$this->productManager->findOneBy(['reference' => $product->getReference()])) {
                $this->productManager->save($product);
            }
        }

        return $productFactoryResponse;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findProductsFromXmlDir(): array
    {
        $xmlFilesDir = $this->directoryService->getXmlFilesDir();
        $xmlFiles = $this->systemService->getFilesInPathIndexedByName($xmlFilesDir);

        $productsXml = [];
        try {
            foreach ($xmlFiles as $name => $xmlFile) {
                $xmlFileLoaded = $this->systemService->loadSimpleXmlFile($xmlFilesDir . DIRECTORY_SEPARATOR . "$name." . self::XML_TYPE);

                $jsonData = json_encode($xmlFileLoaded);
                /** @var ProductsXml $productsDeserialized */
                $deserializedProducts = $this->serializer->deserialize($jsonData, ProductsXml::class, self::JSON_TYPE);
                $productsXml = array_merge($productsXml, $deserializedProducts->getItem());
            }
        } catch (\Exception $exception) {
            throw new \Exception($this->translator->trans('error.loading_products_from_xml'));
        }

        return $productsXml;
    }
}