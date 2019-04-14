<?php

namespace App\Controller;

use App\Datatables\ProductDatatable;
use App\Entity\ProductGlobal;
use App\Service\ProductGlobalService;
use Sg\DatatablesBundle\Response\DatatableResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     * @param ProductDatatable     $datatable
     * @param ProductGlobalService $productGlobalService
     *
     * @return Response
     * @throws \Exception
     */
    public function index(ProductDatatable $datatable, ProductGlobalService $productGlobalService): Response
    {
        $productGlobalService->refresh();
        $datatable->buildDatatable();

        return $this->render('product/index.html.twig', ['datatable' => $datatable]);
    }

    /**
     * @Route("/ajax-update", name="product_index_ajax_update", options = {"expose" = true}, methods={"POST"})
     *
     * @param ProductDatatable  $datatable
     * @param DatatableResponse $datatableResponse
     *
     * @return JsonResponse
     */
    public function ajaxUpdateAction(
        ProductDatatable $datatable,
        DatatableResponse $datatableResponse
    ): ?JsonResponse {
        try {
            $datatable->buildDatatable();

            $datatableResponse->setDatatable($datatable);
            $datatableResponse->getDatatableQueryBuilder();

            return $datatableResponse->getResponse();

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/show/{reference}", name="product_show", methods={"GET"})
     * @param ProductGlobal $productGlobal
     *
     * @return Response
     */
    public function show(ProductGlobal $productGlobal): Response
    {
        return $this->render('product/show.html.twig', [
            'entity' => $productGlobal,
        ]);
    }
}
