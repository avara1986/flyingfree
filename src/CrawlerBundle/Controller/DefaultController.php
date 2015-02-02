<?php

namespace CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Goutte\Client;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => $name));
    }
    public function getUrlAction()
    {
     $client = new Client();
     $crawler = $client->request('GET', 'https://www.infojobs.net/');
     //print $crawler->text();
     //$crawler = $client->click($crawler->selectLink('Sign in')->link());
     $form = $crawler->selectButton('Buscar')->form();
     $crawler = $client->submit($form, array('palabra' => 'PHP', 'of_provincia' => '33'));
     $crawler->filter('#offer-list > li')->each(function ($node) {
      $patrón = '/PHP Zend/';
      $coincidencias = array();
      preg_match($patrón, $node->text(), $coincidencias, PREG_OFFSET_CAPTURE);
      print $node->text() . "<br>";
      if(count($coincidencias)){
          print "******<br>";
          print "ENCONTRADO!<br>";
          //var_dump($node->seeLink('h2'));
          $node->filter('h2 a')->each(function ($subnode) {
              var_dump($subnode->attr('href'));
          });
          print "<br>******<br>";
      }
         
         print "---------------<br>";
     });
     return $this->render('CrawlerBundle:Default:index.html.twig', array('name' => "test"));
    }
}
