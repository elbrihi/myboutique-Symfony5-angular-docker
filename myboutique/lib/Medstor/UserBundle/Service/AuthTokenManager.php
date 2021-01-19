<?php

namespace Medstor\UserBundle\Service ;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface ;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface ;
use Medstor\UserBundle\Form\CredentialsType;
use Medstor\UserBundle\Entity\AuthToken;
use  Medstor\UserBundle\Entity\Credentials;

use Symfony\Component\HttpFoundation\Response;


class AuthTokenManager 
{
    private $entity_manager;
    private $form_factory ;
    private $encoder;
    public function __construct
    (
        EntityManagerInterface $entity_manager,
        FormFactoryInterface $form_factory,
        UserPasswordEncoderInterface  $encoder
    )
    {
        $this->entity_manager = $entity_manager;
        $this->form_factory = $form_factory;
        $this->encoder = $encoder ;
    }   

    public function postAuthTokens($request)
    {
        $credentials = new Credentials();

        $form = $this->form_factory->create(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $user = $this->entity_manager->getRepository('MedstorUserBundle:User')
                    ->findOneByUsername($credentials->getLogin());

        if(!$user)
        {
            return $this->invalidCredentials();
        }

        $isPasswordValid = $this->encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();

        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $this->entity_manager->persist($authToken);
        $this->entity_manager->flush();

        return $authToken;

       
        
    }

    public function fetchAuthToken($value)
    {
        $authToken = $this->entity_manager->getRepository('MedstorUserBundle:AuthToken')
                        ->findOneBy([
                            'value' => $value
                        ]);
        if(!$authToken)
        {
            return ;
        }
        return $authToken->getUser();
    }
    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}

?>