<?php

namespace Medstor\CatalogBundle\Form;

use Medstor\CatalogBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('price')
            ->add('sku')
            ->add('url_key')
            ->add('description')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Medstor\CatalogBundle\Entity\Product',
            'csrf_protection' => false
        ]);
    }
}
