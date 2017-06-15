<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="DataBundle\Repository\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
{
    /**
     * @ORM\ManyToOne(targetEntity="DataBundle\Entity\Service_cat")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $service_cat;

    /**
     * @ORM\ManyToOne(targetEntity="DataBundle\Entity\Ville")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $ville;

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=65535)
     */
    private $content;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="articles_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @var int
     * @var string
     * @ORM\ManyToOne(targetEntity="DataBundle\Entity\Gabarit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $view;


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
     * Set title
     *
     * @param string $title
     *
     * @return Article
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
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * Set view
     *
     * @param int $view
     *
     * @return Gabarit
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return int
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set serviceCat
     *
     * @param \DataBundle\Entity\Service_cat $serviceCat
     *
     * @return Article
     */
    public function setServiceCat($serviceCat)
    {
        $this->service_cat = $serviceCat;

        return $this;
    }

    /**
     * Get serviceCat
     *
     * @return \DataBundle\Entity\Service_cat
     */
    public function getServiceCat()
    {
        return $this->service_cat;
    }

    /**
     * Set ville
     *
     * @param \DataBundle\Entity\Ville $ville
     *
     * @return Article
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \DataBundle\Entity\Ville
     */

    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param File|null $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

}
