<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JobBundle\Entity\Tag;
use JobBundle\Entity\Job;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $jobs = $this->getDoctrine()->getRepository('JobBundle:Job');
        $this->joblist = $jobs->findAll();
        return $this->render('JobBundle:Default:index.html.twig', array('jobs' => $this->joblist));
    }
    public function taglistAction()
    {
        $tags = $this->getDoctrine()->getRepository('JobBundle:Tag');
        $this->taglist = $tags->findAll();
        return $this->render('JobBundle:Default:tag.html.twig', array('taglist' => $this->taglist));
    }
    public function tagCreateAction(Request $request)
    {
        $tag = new Tag;
        $form = $this->createFormBuilder($tag)
            ->add('name', 'text')
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($tag);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
        }

        return $this->render('JobBundle:Default:tag_create.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,

        ));
    }
}
