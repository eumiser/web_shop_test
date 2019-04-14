<?php

namespace App\Controller;

use App\Form\ProductCsvUploadType;
use App\Model\Form\ProductCsvUpload;
use App\Service\ProductImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/product-import")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/", name="product_upload_index")
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        $productUpload = new ProductCsvUpload();
        $form = $this->createUploadForm($productUpload);

        return $this->render('product/import_by_file.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/form/submit", name="product_upload_csv_submit")
     *
     * @param Request              $request
     * @param ProductImportService $productImportService
     * @param TranslatorInterface  $translator
     *
     * @return RedirectResponse|Response
     */
    public function uploadFromExcelAction(
        Request $request,
        ProductImportService $productImportService,
        TranslatorInterface $translator
    ) {
        $productCsvUpload = new ProductCsvUpload();
        $uploadForm = $this->createUploadForm($productCsvUpload);
        $uploadForm->handleRequest($request);
        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            try {
                $productFactoryModel = $productImportService->loadProductsFromExcelFile(
                    $productCsvUpload->file->getRealPath(),
                    $productCsvUpload->overwrite
                );

                if (!empty($productFactoryModel->getErrors())) {
                    $this->addFlash('warning',
                        "{$translator->trans('form.import_error')} {$translator->trans('product.entity_plural')}: {implode('</br> - ', $productFactoryModel->getErrors())}");

                    return $this->render('product/import_by_file.html.twig', ['form' => $uploadForm->createView(),]);
                }
            } catch (\Exception $exception) {
                $this->addFlash(
                    'danger',
                    "{$translator->trans('form.import_error')}: </br>{$exception->getMessage()}"
                );

                return $this->render('product/import_by_file.html.twig', ['form' => $uploadForm->createView(),]);
            }

            $this->addFlash('success',
                "{$translator->trans('product.entity_plural')} {$translator->trans('form.import_successfully')}");

            return $this->redirectToRoute('product_upload_index');
        }

        return $this->render('product/import_by_file.html.twig', ['form' => $uploadForm->createView(),]);
    }

    /**
     * @param ProductCsvUpload $fileSelectorWithProjectLang
     *
     * @return FormInterface
     */
    private function createUploadForm(ProductCsvUpload $fileSelectorWithProjectLang
    ): FormInterface {
        return $this->createForm(
            ProductCsvUploadType::class,
            $fileSelectorWithProjectLang,
            [
                'action' => $this->generateUrl('product_upload_csv_submit'),
                'attr' => ['submit_button' => 'form.import'],
            ]
        );
    }
}