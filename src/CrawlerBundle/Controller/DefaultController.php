<?php

namespace CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Goutte\Client;
use JobBundle\Entity\Tag;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => $name));
    }
    public function infoJobsJobsAction()
    {
        $tags = $this->getDoctrine()->getRepository('JobBundle:Tag');
        $taglist = $tags->findAll();
        $client = new Client();
        $num_tags = count($taglist);
        //dump($taglist[1]);
        //die();
        for($i=0;$i<$num_tags;$i++){
            $tag = $taglist[$i]->getName();
            $crawler = $client->request('GET', 'https://www.infojobs.net/');
            $form = $crawler->selectButton('Buscar')->form();
            $crawler = $client->submit($form, array('palabra' => $tag, 'of_provincia' => '33'));
            $crawler->filter('#offer-list > li')->each(function ($node) {
                $patron = '/account manager/i';
                $coincidencias = array();
                preg_match($patron, $node->text(), $coincidencias, PREG_OFFSET_CAPTURE);
                    //print $node->text() . "<br>";
                    if(count($coincidencias)){
                         print "******<br>";
                         print "ENCONTRADO para account manager!<br>";
                         //var_dump($node->seeLink('h2'));
                         $node->filter('h2 a')->each(function ($subnode) {
                          var_dump($subnode->attr('href'));
                         });
                         print "Type contract: ".$node->filter('.tag-group.hide-small-device > li')->eq(0)->text()."<br>";
                         print "Horario: ".$node->filter('.tag-group.hide-small-device > li')->eq(1)->text()."<br>";
                         print "Salario:".$node->filter('.tag-group.hide-small-device > li')->eq(2)->text()."<br>";
                         die();
                         print "<br>******<br>";
                    }
            });
        }
        return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => "test"));
    }
}
