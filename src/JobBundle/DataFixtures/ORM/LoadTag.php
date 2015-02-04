<?php
namespace Vaken\ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use \Doctrine\Common\Persistence\ObjectManager;
use \JobBundle\Entity\Tag as Tag;

class LoadClientData implements FixtureInterface
{
    /**
    *
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        //Create a common place
        $tag=new Tag();
        $tag->setName('Account Manager');
        $manager->persist($tag);
        $manager->flush();

        $tag=new Tag();
        $tag->setName('marketing assistant');
        $manager->persist($tag);
        $manager->flush();
    }
}