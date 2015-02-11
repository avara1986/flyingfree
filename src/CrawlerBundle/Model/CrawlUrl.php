<?php
namespace CrawlerBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Goutte\Client;
use JobBundle\Entity\Job;

class CrawlUrl
{
    private $tags;

    private $checkjob;

    private $new_jobs_founded;

   private $om;

    public function __construct(ObjectManager $om){
        $this->om = $om;
        $this->tags = $om->getRepository('JobBundle:Tag');
        $this->checkjob = $om->getRepository('JobBundle:Job');
    }

    public function searchAndSave($website){
        $this->new_jobs_founded = 0;
        $this->taglist = $this->tags->findAll();
        $client = new Client();
        $num_tags = count($this->taglist);
        for($i=0;$i<$num_tags;$i++){
            $this->pos = $i;
            $this->tag = $this->taglist[$this->pos]->getName();
            $crawler = $client->request('GET', $website);
            $form = $crawler->selectButton('Buscar')->form();
            $crawler = $client->submit($form, array('palabra' => $this->tag, 'of_provincia' => '33'));
            $crawler->filter('#offer-list > li')->each(function ($node) {
                $patron = '/'.$this->tag.'/i';
                $coincidencias = array();
                preg_match($patron, $node->text(), $coincidencias, PREG_OFFSET_CAPTURE);
                if(count($coincidencias)){
                    $checkjoblist = $this->checkjob->findBy(array('urlPath' => 'https:'.$node->filter('h2 a')->attr('href')));
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
                        $this->om->persist($job);
                        $this->om->flush();
                        $this->new_jobs_founded++;
                    }else{
                        for($j=0;$j<$num_checkjoblist;$j++){
                            $checkjoblist[$j]->addTag($this->taglist[$this->pos]);
                            $this->om->persist($checkjoblist[$j]);
                            $this->om->flush();
                        }
                    }
                }
            });
        }
        return $this->new_jobs_founded;
    }

}


