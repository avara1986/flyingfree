<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}
