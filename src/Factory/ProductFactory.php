<?php


namespace App\Factory;

use App\Entity\Product;
use App\Manager\ProductManager;
use App\Model\ProductFactoryResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ProductFactory
 * @package App\Factory
 */
class ProductFactory
{
    /**
     * @var ProductManager
     */
    private $productManager;

    private $translator;

    /**
     * ProductFactory constructor.
     *
     * @param ProductManager      $productManager
     * @param TranslatorInterface $translator
     */
    public function __construct(ProductManager $productManager, TranslatorInterface $translator)
    {
        $this->productManager = $productManager;
        $this->translator = $translator;
    }

    /**
     * @param array $rowsCsv
     *
     * @return ProductFactoryResponse
     */
    public function getProductsFromCsvData(array $rowsCsv): ProductFactoryResponse
    {
        $productFactoryResponse = new ProductFactoryResponse();

        foreach ($rowsCsv as $row) {
            try {
                $productFactoryResponse->addProduct($this->getNewProductFromRowData($row));
            } catch (\Exception $exception) {
                $productFactoryResponse->addError("{$this->translator->trans('error.in_line')} {$row['line_row']}: {$exception->getMessage()}");
            }
        }

        return $productFactoryResponse;
    }

    /**
     * @param $row
     *
     * @return Product
     * @throws \Exception
     */
    private function getNewProductFromRowData($row): Product
    {
        $newProduct = $this->productManager->create();

        $errors = [];
        if (!(int)$row['id']) {
            $errors[] = $this->translator->trans('product.error_import_id');
        }
        if (empty($row['manufacturer']) && empty($row['name'])) {
            $errors[] = $this->translator->trans('product.error_import_title');
        }
        if (!(float)$row['price']) {
            $errors[] = $this->translator->trans('product.error_import_price');
        }
        if (empty($row['product_image'])) {
            $errors[] = $this->translator->trans('product.error_import_product_image');
        }

        if ($errors) {
            throw new \Exception(implode('. ', $errors));
        }

        $newProduct->setReference((int)$row['id']);
        $newProduct->setTitle("{$row['manufacturer']} {$row['name']}");
        $newProduct->setDescription($row['additional']);
        $newProduct->setPrice((float)$row['price']);
        $newProduct->setImageLink($row['product_image']);

        return $newProduct;
    }
}