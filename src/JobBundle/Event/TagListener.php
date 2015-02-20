<?php

namespace JobBundle\Event;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use JobBundle\Entity\Tag;


class TagListener{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function onTagCreate(TagEvent $tag){
        dump($tag->tag->getName());
        $this->logger->info('Inserted new tag: '.$tag->tag->getName());
    }
}
