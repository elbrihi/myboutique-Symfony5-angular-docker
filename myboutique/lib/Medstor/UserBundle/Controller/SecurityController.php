<?php

namespace Medstor\UserBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/user")
 * 
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET","POST"})
     */
    public function loginAction(): Response
    {

        $response = new Response();
        return $response;
        //return $this->render('security/login.html.twig');
    }

     /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logoutAction(): Response
    {
        return $this->render('security/login.html.twig');
    }
    
}
