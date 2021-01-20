<?php

namespace Medstor\CatalogBundle\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  Medstor\CatalogBundle\Service\ProductManager ;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * 
 * @Route("api/catalog",name="catalog_")
 */
class ProductController extends AbstractController
{
    private $product_manager ;

    public function __construct(ProductManager $product_manager)
    {
        $this->product_manager = $product_manager ;
    }
    /**
     * @Route("/product", name="new_product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * 
     * @Rest\View()
     * @Rest\Get("/category/products"))
     */
    public function fetchAllProduct()
    {   
       return  $this->product_manager->fetchAllProduct();

    }
    /**
     * @Rest\View()
     * @Rest\Post("/category/{id}/product/new",name="new_product")
     */
    public function newProduct(Request $request)
    {
    
        return $this->product_manager->newProduct($request,$request->get('id'),$this->getUser()) ;
    }
    /**
     * @Rest\View()
     * @Rest\Post("/category/product/update/{id}",name="update_product")
     */
    public function updateProduct(Request $request)
    {
    
        return $this->product_manager->updateProduct($request,$request->get('id')) ;
    }

       /**
     * 
     * @Rest\View()
     * @Rest\Delete("/category/product/delete/{id}",name="delete_catagory")
     */
    public function deleteProduct(Request $request)
    {
        return $this->product_manager->deleteProduct($request,$request->get('id'));
    }

}
