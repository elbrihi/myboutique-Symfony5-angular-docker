<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Test;

class TestController extends AbstractController
{
    private $adminEmail;
   
    public function __construct($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        //dump($this->app_test );
;       // die;
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
