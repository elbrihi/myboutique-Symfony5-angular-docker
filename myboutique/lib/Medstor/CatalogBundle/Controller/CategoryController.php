<?php

namespace Medstor\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View; 
use Medstor\CatalogBundle\Service\Test;
use Medstor\CatalogBundle\Entity\Category;
use Medstor\CatalogBundle\Service\CategoryManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @Route("api/catalog",name="catalog")
 */
class CategoryController extends AbstractController 
{
    private $test ;
    private $category_manager;
    public function __construct(CategoryManager $category_manager)
    {
        
        $this->category_manager = $category_manager;
    }
   
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        
        $response = new Response();
        return $response;
    }

    /**
     * 
     * @Rest\View()
     * @Rest\Get("/category/fetch",name="_fetch_catagory")
     */
    public function fetchCategory()
    {
        return $this->category_manager->fetchCategory();
    }
    

    /**
     * 
     * @Rest\View()
     * @Rest\Post("/category/new",name="_new_catagory")
     */
    public function newCategory(Request $request)
    {
        return $this->category_manager->newCategory($request);
    }
    
    /**
     * 
     * @Rest\View()
     * @Rest\Post("/category/update/{id}",name="_upadate_catagory")
     */
    public function updateCategory(Request $request)
    {
        return $this->category_manager->updateCategory($request,$request->get('id'));
    }

    /**
     * 
     * @Rest\View()
     * @Rest\Delete("/category/delete/{id}",name="_delete_catagory")
     */
    public function deleteCategory(Request $request)
    {
        return $this->category_manager->deleteCategory($request,$request->get('id'));
    }

    
}
