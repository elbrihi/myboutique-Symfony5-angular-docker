<?php

namespace Medstor\UserBundle\Service ;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface ;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface ;

use Medstor\UserBundle\Entity\User;
use Medstor\UserBundle\Form\UserType;
class UserManager
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

    public function fetchUsers()
    {
        
        $users = $this->entity_manager->getRepository('MedstorUserBundle:User')
                ->findAll();
        return $users;
    }
    public function newUser($request)
    {
        $user = new User();

        $form = $this->form_factory->create(UserType::class,$user);

        $form->submit($request->request->all(),false);

        if($form->isValid())
        {
            
            $encoded = $this->encoder->encodePassword($user, $user->getPlainPassword());
            //dump($user);
            $user->setPassword($encoded);

            
            $this->entity_manager->persist($user);
            
            $this->entity_manager->flush();

            return $user;
        }
        return $form ;
    }
    public function updateUser($request,$id_user)
    {
        $user = new User();

        $user = $this->entity_manager->getRepository('MedstorUserBundle:User')
        
        ->find($id_user);

        $user->setUsername($request->get('username'));
        $user->setPassword($request->get('password'));

        $form = $this->form_factory->create(UserType::class,$user);

        $form->submit($request->request->all(),false);

        if($form->isValid())
        {
            
            $this->entity_manager->flush();

            return $user;
        }
        return $form ;
    }
    public function deleteUser($request,$id_user)
    {
        $user = $this->entity_manager->getRepository('MedstorUserBundle:User')
                    ->find($id_user);
        
        $this->entity_manager->remove($user);
        $this->entity_manager->flush();
    }
}


?>