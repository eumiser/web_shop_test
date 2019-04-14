<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductType
 */
class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                TextType::class,
                array(
                    'label' => 'product.title',
                    'attr' => ['class' => 'form-control']
                )
            )
            ->add('description',
                TextType::class,
                array(
                    'label' => 'product.description',
                    'attr' => ['class' => 'form-control']
                )
            )
            ->add('image_link',
                TextType::class,
                array(
                    'label' => 'product.image_link',
                    'attr' => ['class' => 'form-control']
                )
            )
            ->add('price',
                MoneyType::class,
                array(
                    'label' => 'product.price',
                    'attr' => ['class' => 'form-control']
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_product';
    }
}
