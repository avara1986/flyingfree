<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JobBundle:Default:index.html.twig', array('name' => $name));
    }
}
