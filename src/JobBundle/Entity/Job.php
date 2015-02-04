<?php

namespace JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Job
{

    /**
     * @var unknown
     */
    private $id;

    protected $created;

    protected $lastUpdated;

    protected $title;

    protected $description;

    protected $url;

    protected $urlPath;

    protected $typeContract;

    protected $salary;

    protected $accepted;

    protected $rank;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }
    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setLastUpdated(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreated() == null)
        {
            $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));
        }
    }
}
