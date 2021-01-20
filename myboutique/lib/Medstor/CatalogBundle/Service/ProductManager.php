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

    public function fetchAllProduct()
    {
        return $this->entity_manager->getRepository('Medstor\CatalogBundle\Entity\Product')
                ->findAll();
    }
    public function newProduct($request,$id_category,$user_provider)
    {

        $category = $this->entity_manager->getRepository('MedstorCatalogBundle:Category')
                                        ->find($id_category);

        $product = new Product();
        
        $file = $request->files->get('image');
        
        $file = $this->image_uploader->upload($file);

        $form = $this->form_factory->create(ProductType::class, $product);
        
        $form->submit($request->request->all());
       
        $data = $form->getData();
       
        $product->setImage($file);

        $product->setUser($user_provider);

        $product->setCategory($category);


        
        if ($form->isSubmitted() && $form->isValid()) 
        {
           
            $this->entity_manager->persist($product);
            
            $this->entity_manager->flush();


            return $product ;
        }
        else
        {
            return $form ;
        }
    }
    public function updateProduct($request, $id_category)
    {
        


        $product = new Product();
  
        $product = $this->entity_manager->getRepository('MedstorCatalogBundle:Product')
        
        ->find($id_category);
       
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