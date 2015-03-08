<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UserBundle:Default:index.html.twig', array('name' => $name));
    }
    public function userCreateAction(Request $request)
    {
        $user = new User;
        $form = $this->createFormBuilder($user)
        ->add('email', 'text')
        ->add('username', 'text')
        ->add('password', 'password')
        ->add('roles', 'collection', array(
            'type'   => 'choice',
            'options'  => array(
                'choices'   => array(
                    'ROLE_USER' => 'User',
                    'ROLE_ADMIN' => 'Administrator',
                ),
            ),
        ))
        ->add('save', 'submit')
        ->getForm();

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if($form->isValid()){
            $user->setSalt('');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('UserBundle:Default:user_create.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,

        ));
    }
}
