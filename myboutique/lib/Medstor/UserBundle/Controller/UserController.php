<?php

namespace Medstor\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Medstor\UserBundle\Service\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Medstor\UserBundle\Security\TokenAuthenticator;
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Request;
use Medstor\UserBundle\Entity\User;


/**
 * 
 * @Route("api/user",name="api_user")
 */
class UserController extends AbstractController
{

    private $user_manager ;

    public function __construct(UserManager $user_manager)
    {
        $this->user_manager = $user_manager;
    }
     /**
     * 
     *@Rest\View()
     *@Rest\Get("/fetch", name="_fetch" ) 
     */
    public function fetchUsers(Request $request)
    {
        return $this->user_manager->fetchUsers($request,$request->get('id'));
    }
    
    
    /**
     * 
     *@Rest\View()
     *@Rest\Post("/new", name="_new" ) 
     */
    public function newUser(Request $request)
    {
        
        return $this->user_manager->newUser($request);
    }


    /**
     * 
     *@Rest\View()
     *@Rest\Post("/update/{id}", name="_update" ) 
     */
    public function updateUser(Request $request)
    {
       
        return $this->user_manager->updateUser($request,$request->get('id'));
    }


    /**
     * 
     *@Rest\View()
     *@Rest\Post("/delete/{id}", name="_delete" ) 
     */
    public function deleteUser(Request $request)
    {
       
        return $this->user_manager->deleteUser($request,$request->get('id'));
    }

    
}
