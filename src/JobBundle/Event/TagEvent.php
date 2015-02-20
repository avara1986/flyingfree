<?php

namespace JobBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use JobBundle\Entity\Tag;


class TagEvent extends Event
{

    public $tag;

    public function __construct(Tag $tag){
        $this->tag = $tag;
    }
}
