<?php

namespace Medstor\CatalogBundle\Service;

use Medstor\CatalogBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory ;
use Symfony\Component\Form\FormFactoryInterface ;
use Medstor\CatalogBundle\Form\CategoryType ;
use Medstor\CatalogBundle\Service\ImageUploader;


class CategoryManager
{
    private $entity_manager ;
    private $form_factory ;
    private $image_uploader ;
    private $targetDir;
    public function __construct
    (
        EntityManagerInterface $entity_manager,
        FormFactoryInterface $form_factory,
        ImageUploader $image_uploader,
        $targetDir
        
    )
    {
        $this->entity_manager = $entity_manager ;
        $this->form_factory = $form_factory ;
        $this->image_uploader = $image_uploader;
        $this->targetDir = $targetDir;
    }

    public function fetchCategory()
    {
      
        $category = $this->entity_manager->getRepository('MedstorCatalogBundle:Category')
                        ->findAll();
        return $category;
        
    }
    public function updateCategory($request, $id_category)
    {
        
        $category = $this->entity_manager->getRepository('MedstorCatalogBundle:Category')
        
        ->find($id_category);
        
        $category->setTitle($request->get('title'));
        $category->setUrlKey($request->get('url_key'));
        $category->setDescription($request->get('description'));
      
        $form = $this->form_factory->create(CategoryType::class, $category);    
        $form->submit($request->request->all(),false);
        
        if($file = $request->files->get('image'))
        {
            $file = $this->image_uploader->upload($file);
            $category->setImage($file);  
        }
              
        if($form->isValid())
        {
            
            $this->entity_manager->flush();

            return $category ;
        }

        return $form;
    }
    public function newCategory($request)
    {
       
        $user =  $this->findUserByToken($request->headers->get('Authorization'));


        dd($user);

        $category = new Category();

        $file = $request->files->get('image');
        
        $file = $this->image_uploader->upload($file);

        $form = $this->form_factory->create(CategoryType::class, $category);
        
        $form->submit($request->request->all());
       
        $category->setImage($file);

        $data = $form->getData();
       
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->entity_manager->persist($category);
            
            $this->entity_manager->flush();

            return $category;
        } 
             
        
    }
    public function deleteCategory($request,$id_category)
    {
        $category = $this->entity_manager->getRepository('MedstorCatalogBundle:Category')
                    ->find($id_category);
        
        $this->entity_manager->remove($category);
        $this->entity_manager->flush();
    }

    
    public function findUserByToken($value)
    {
        
        $user = $this->entity_manager->createQueryBuilder('u')
               ->from('');

        return $user;
        /**return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;*/
    }
    

   
}

?>