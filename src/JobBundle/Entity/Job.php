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

    protected $tags;

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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Job
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     * @return Job
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime 
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Job
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set urlPath
     *
     * @param string $urlPath
     * @return Job
     */
    public function setUrlPath($urlPath)
    {
        $this->urlPath = $urlPath;

        return $this;
    }

    /**
     * Get urlPath
     *
     * @return string 
     */
    public function getUrlPath()
    {
        return $this->urlPath;
    }

    /**
     * Set typeContract
     *
     * @param string $typeContract
     * @return Job
     */
    public function setTypeContract($typeContract)
    {
        $this->typeContract = $typeContract;

        return $this;
    }

    /**
     * Get typeContract
     *
     * @return string 
     */
    public function getTypeContract()
    {
        return $this->typeContract;
    }

    /**
     * Set salary
     *
     * @param string $salary
     * @return Job
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return string 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set accepted
     *
     * @param integer $accepted
     * @return Job
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer 
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Job
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add tags
     *
     * @param \JobBundle\Entity\Tag $tags
     * @return Job
     */
    public function addTag(\JobBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \JobBundle\Entity\Tag $tags
     */
    public function removeTag(\JobBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
