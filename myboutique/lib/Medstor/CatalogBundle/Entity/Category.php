<?php

namespace Medstor\CatalogBundle\Entity;

use Medstor\CatalogBundle\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_key;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Medstor\CatalogBundle\Entity\Product", mappedBy="category")
     */
    private $products ;


    /**
     * 
     * @ORM\ManyToOne(targetEntity="Medstor\UserBundle\Entity\User", inversedBy="category")
     */
    private $user ;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrlKey(): ?string
    {
        return $this->url_key;
    }

    public function setUrlKey(string $url_key): self
    {
        $this->url_key = $url_key;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }


    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setProduct()
    {

    }

    public function getProduct()
    {
        
    }

    public function setUser($user):self
    {
        $this->user = $user ; 

        return $this ;
    }
    public function getUser($user)
    {
        $this->user = $user ;
    }
}
