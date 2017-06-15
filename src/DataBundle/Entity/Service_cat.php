<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service_cat
 *
 * @ORM\Table(name="service_cat")
 * @ORM\Entity(repositoryClass="DataBundle\Repository\Service_catRepository")
 */
class Service_cat
{
    /**
     * @ORM\ManyToOne(targetEntity="DataBundle\Entity\Service")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $service;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Service_cat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set service
     *
     * @param \DataBundle\Entity\Service $service
     *
     * @return Service_cat
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \DataBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
