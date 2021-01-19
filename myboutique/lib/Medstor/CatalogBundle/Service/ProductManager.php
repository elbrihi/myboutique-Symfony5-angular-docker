<?php

namespace Medstor\CatalogBundle\Service;

use Medstor\CatalogBundle\Entity\Product ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface ;
use Medstor\CatalogBundle\Form\ProductType ;
use Medstor\CatalogBundle\Service\ImageUploader;



class ProductManager
{
    private $entity_manager ;
    private $form_factory ;
    private $image_uploader ;

    public function __construct
    (
        EntityManagerInterface $entity_manager,
        FormFactoryInterface $form_factory,
        ImageUploader $image_uploader 
    )
    {
        $this->entity_manager = $entity_manager ;
        $this->form_factory = $form_factory ;
        $this->image_uploader = $image_uploader;
    }

    public function newProduct($request,$id_category)
    {

        $category = $this->entity_manager->getRepository('MedstorCatalogBundle:Category')
                                        ->find($id_category);

        $product = new Product();
        
        $product->setCategory($category);

        $form = $this->form_factory->create(ProductType::class, $product);
        
        $form->submit($request->request->all());
       
        $data = $form->getData();
       
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
           
            $this->entity_manager->persist($product);
            
            $this->entity_manager->flush();

            return $product ;
        }
    }
    public function updateProduct($request, $id_category)
    {
        
        $product = $this->entity_manager->getRepository('MedstorCatalogBundle:Product')
        
        ->find($id_category);
        
        $product->setTitle($request->get('title'));
        $product->setPrice($request->get('price'));
        $product->setUrlKey($request->get('url_key'));
        $product->setUrlKey($request->get('url_key'));
        $product->setDescription($request->get('description'));
      
        $form = $this->form_factory->create(ProductType::class, $product);    
        $form->submit($request->request->all(),false);
        
        if($file = $request->files->get('image'))
        {
            $file = $this->image_uploader->upload($file);
           
            $product->setImage($file);  
        }
              
        if($form->isValid())
        {
            
            $this->entity_manager->flush();

            return $product ;
        }

        return $form;
    }

    public function deleteProduct($request,$id_product)
    {
        $product = $this->entity_manager->getRepository('MedstorCatalogBundle:Product')
                    ->find($id_product);
        
        $this->entity_manager->remove($product);
        $this->entity_manager->flush();
    }

}
?>