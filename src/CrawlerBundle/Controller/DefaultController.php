<?php

namespace CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Goutte\Client;
use JobBundle\Entity\Tag;
use JobBundle\Entity\Job;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => $name));
    }
    public function infoJobsJobsAction()
    {
        $new_jobs_founded = $this->get('crawler.crawl_url')->searchAndSave('https://www.infojobs.net/');
        if($new_jobs_founded>0){
            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
            ->setSubject($new_jobs_founded.' nuevos "Flying Free" encontrados!')
            ->setFrom('frlyingfree@we-ma.com')
            ->setTo('a.vara@gobalo.es')
            ->setBody(
                    $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                            'CrawlerBundle:Default:email.html.twig',
                            array()
                    ),
                    'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                    $this->renderView(
                            'Emails/registration.txt.twig',
                            array('name' => $name)
                    ),
                    'text/plain'
            )
            */
            ;
            $mailer->send($message);
        }

        return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => "test"));
    }
}
