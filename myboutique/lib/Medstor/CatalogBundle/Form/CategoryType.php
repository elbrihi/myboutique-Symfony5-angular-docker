<?php

namespace Medstor\CatalogBundle\Form;

use Medstor\CatalogBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url_key')
            ->add('description')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults([
            'data_class' => Category::class,
        ]);*/

        $resolver->setDefaults([
            'data_class' => 'Medstor\CatalogBundle\Entity\Category',
            'csrf_protection' => false
        ]);
    }
}
