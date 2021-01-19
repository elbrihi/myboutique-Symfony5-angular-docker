<?php

namespace Medstor\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Request;
use Medstor\UserBundle\Service\AuthTokenManager;

/**
 * 
 * @Route("api/user")
 */
class AuthTokenController extends AbstractController
{
    private $auth_token_manager;
    public function __construct
    (AuthTokenManager $auth_token_manager)
    {
        $this->auth_token_manager = $auth_token_manager ;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/auth-tokens")
     */
    public function postAuthTokensAction(Request $request)
    {
        return $this->auth_token_manager->postAuthTokens($request);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/fetchauthtoken", name="fetchauthtoken")
     * 
     */
    public function fetechAuthToken()
    {
        return $this->auth_token_manager->fetchAuthToken();
    }
    public function loginAction(Request $request)
    {
        return $this->auth_token_manager->postAuthTokens($request);
    }
}
