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
        $this->new_jobs_founded = 0;
        $this->em = $this->getDoctrine()->getManager();
        $tags = $this->getDoctrine()->getRepository('JobBundle:Tag');
        $this->taglist = $tags->findAll();
        $client = new Client();
        $num_tags = count($this->taglist);
        //dump($taglist[1]);
        //die();
        for($i=0;$i<$num_tags;$i++){
            $this->pos = $i;
            $this->tag = $this->taglist[$this->pos]->getName();
            $crawler = $client->request('GET', 'https://www.infojobs.net/');
            $form = $crawler->selectButton('Buscar')->form();
            $crawler = $client->submit($form, array('palabra' => $this->tag, 'of_provincia' => '33'));
            $crawler->filter('#offer-list > li')->each(function ($node) {
                $patron = '/'.$this->tag.'/i';
                $coincidencias = array();
                preg_match($patron, $node->text(), $coincidencias, PREG_OFFSET_CAPTURE);
                    //print $node->text() . "<br>";
                    if(count($coincidencias)){
                        $checkjob = $this->getDoctrine()->getRepository('JobBundle:Job');
                        $checkjoblist = $checkjob->findBy(array('urlPath' => 'https:'.$node->filter('h2 a')->attr('href')));
                        $num_checkjoblist = count($checkjoblist);
                        if($num_checkjoblist==0){
                            $job=new Job();//
                            $job->setUrl('http//infojobs.net');
                            $job->setTitle($node->filter('h2 a')->text());
                            $job->setUrlPath('https:'.$node->filter('h2 a')->attr('href'));
                            $job->setDescription($node->filter('.result-list-description')->text());
                            if($node->filter('.tag-group.hide-small-device > li')->eq(2)->text() != 'Salario no especificado'){
                                $job->setSalary($node->filter('.tag-group.hide-small-device > li')->eq(2)->text());
                            }
                            if($node->filter('.tag-group.hide-small-device > li')->eq(2)->text() != ''){
                                $job->setTypeContract($node->filter('.tag-group.hide-small-device > li')->eq(0)->text());
                            }
                            $job->setAccepted(2);
                            $job->setRank(0);
                            $job->addTag($this->taglist[$this->pos]);
                            $this->em->persist($job);
                            $this->em->flush();
                            $this->new_jobs_founded++;
                        }else{
                            for($j=0;$j<$num_checkjoblist;$j++){
                                $checkjoblist[$j]->addTag($this->taglist[$this->pos]);
                                $this->em->persist($checkjoblist[$j]);
                                $this->em->flush();
                            }
                        }
                    }
            });
        }
        if($this->new_jobs_founded>0){
            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
            ->setSubject($this->new_jobs_founded.' nuevos "Flying Free" encontrados!')
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
