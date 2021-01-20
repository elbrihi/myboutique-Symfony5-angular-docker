<?php

namespace Medstor\UserBundle\Security;



use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Medstor\UserBundle\Service\AuthTokenManager;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{

    // f/PNmBeyVvUgQk6oslRoII/5zKFfL/KhxaKwhQlDzPi14U35H1d9gsUyEoLNkQKD+Uo=
    private $authtoken_manager;
    public function __construct(AuthTokenManager $authtoken_manager)
    {
        
        $this->authtoken_manager = $authtoken_manager;
    }
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {

       return $request->headers->has('Authorization');
    
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');

        return $authorizationHeader;
       
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $request = new Request();
        $token = $this->authtoken_manager->fetchAuthToken($credentials);
        

        return $token;
                
        if (null === $credentials) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            return null;
        }
        // The "username" in this case is the apiToken, see the key `property`
        // of `your_db_provider` in `security.yaml`.
        // If this returns a user, checkCredentials() is called next:

        return $userProvider->loadUserByUsername($credentials);
    }

    public function checkCredentials($credentials, UserInterface $user)
    { 

        return true;
        
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
   
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
    * Called when authentication is needed, but it's not sent
    */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
?>