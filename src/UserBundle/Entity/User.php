<?php

namespace UserBundle\Entity;

use DataBundle\Entity\Service_cat;
use DataBundle\Entity\Ville;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {

        parent::__construct();

    }

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    protected $town;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp", type="integer", length=255, nullable=true)
     */
    protected $cp;

    /**
     * @var boolean
     *
     * @ORM\Column(name="geolocation", type="boolean")
     */
    protected $geolocation;

    /**
     * @var Ville
     * @ORM\ManyToMany(targetEntity="\DataBundle\Entity\Ville")
     * @ORM\JoinTable(name="user_ville",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ville_id", referencedColumnName="id")}
     *      )
     * @var Ville[]
     */
    protected $followedtown;

    /**
     * @var Service_cat
     * @ORM\ManyToMany(targetEntity="\DataBundle\Entity\Service_cat")
     * @ORM\JoinTable(name="user_service_cat",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="service_cat_id", referencedColumnName="id")}
     *      )
     * @var Service_cat[]
     */
    protected $followedservicecategory;


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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return User
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }


    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set geolocation
     *
     * @param boolean $geolocation
     *
     * @return User
     */
    public function setGeolocation($geolocation)
    {
        $this->geolocation = $geolocation;

        return $this;
    }

    /**
     * Get geolocation
     *
     * @return boolean
     */
    public function getGeolocation()
    {
        return $this->geolocation;
    }

    /**
     * @return Ville
     */
    public function getFollowedtown()
    {
        return $this->followedtown;
    }

    /**
     * @param Ville $followedtown
     */
    public function setFollowedtown($followedtown)
    {
        $this->followedtown = $followedtown;
    }


    /**
     * @return Service_cat
     */
    public function getFollowedservicecategory()
    {
        return $this->followedservicecategory;
    }

    /**
     * @param Service_cat $followedservicecategory
     */
    public function setFollowedservicecategory($followedservicecategory)
    {
        $this->followedservicecategory = $followedservicecategory;
    }

    /**
     * @param Ville $town
     */
    public function addFollowedtown(Ville $town) {
        $this->followedtown->add($town);
    }

    /**
     * @param Service_cat $service_cat
     */
    public function addFollowedservicecategory(Service_cat $service_cat) {
        $this->followedservicecategory->add($service_cat);
    }

}
