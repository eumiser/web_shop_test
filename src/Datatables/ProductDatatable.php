<?php

namespace App\Datatables;

use App\Entity\ProductGlobal;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Style;

class ProductDatatable extends AbstractDatatable
{

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function buildDatatable(array $options = [])
    {
        $actionsDatatable = [];
        $actionsDatatable[] = [
            'route' => 'product_show',
            'route_parameters' => [
                'reference' => 'reference',
            ],
            'label' => $this->translator->trans('label.show'),
            'attributes' => [
                'rel' => 'tooltip',
                'title' => $this->translator->trans('label.show'),
                'class' => 'btn btn-default btn-xs',
                'role' => 'button',
                'aria-hidden' => 'true',
                'data-modal-size' => 'standard',
            ],
        ];

        $this->language->set(
            [
                'cdn_language_by_locale' => true
            ]
        );

        $this->ajax->set(
            [
                'url' => $this->router->generate('product_index_ajax_update'),
                'type' => 'POST',
            ]
        );

        $this->options->set(
            [
                'stripe_classes' => ['strip1', 'strip2', 'strip3'],
                'order_cells_top' => true,
                'display_start' => 0,
                'length_menu' => [10, 25, 50, 75, 100],
                'order_classes' => true,
                'order' => [[0, 'asc']],
                'order_multi' => true,
                'page_length' => 10,
                'scroll_collapse' => false,
                'search_delay' => 0,
                'state_duration' => 7200,
                'classes' => Style::BOOTSTRAP_3_STYLE . ' table-hover table-condensed',
                'individual_filtering' => true,
                'individual_filtering_position' => 'head',
            ]
        );

        $this->features->set(
            [
                'auto_width' => false,
                'defer_render' => false,
                'info' => true,
                'length_change' => true,
                'ordering' => true,
                'paging' => true,
                'processing' => true,
                'scroll_x' => false,
                'scroll_y' => null,
                'searching' => true,
                'state_save' => true,
            ]
        );

        $this->extensions->set(
            [
                'responsive' => true,
            ]
        );

        $this->columnBuilder
            ->add(
                'reference',
                Column::class,
                [
                    'title' => "<div class='datatable-th-actions text-left'>{$this->translator->trans('label.reference')}</div>",
                    'searchable' => true,
                    'orderable' => true,
                    'class_name' => 'text-left',
                ]
            )
            ->add(
                'title',
                Column::class,
                [
                    'title' => "<div class='datatable-th-actions text-left'>{$this->translator->trans('label.title')}</div>",
                    'searchable' => true,
                    'orderable' => true,
                    'class_name' => 'text-left',
                ]
            )
            ->add(
                'price',
                Column::class,
                [
                    'title' => "<div class='datatable-th-actions text-left'>{$this->translator->trans('label.price')}</div>",
                    'searchable' => true,
                    'orderable' => true,
                    'class_name' => 'text-right',
                ]
            )
            ->add(
                null,
                ActionColumn::class,
                array(
                    'title' => "<div class='datatable-th-actions text-right'>{$this->translator->trans('label.actions')}</div>",
                    'actions' => $actionsDatatable,
                    'class_name' => 'text-right',
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return ProductGlobal::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_datatable';
    }
}