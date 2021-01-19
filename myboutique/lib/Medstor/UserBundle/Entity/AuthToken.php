<?php

namespace Medstor\UserBundle\Entity;

use Medstor\UserBundle\Repository\AuthTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthTokenRepository::class)
 */
class AuthToken
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
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * 
     * @ORM\ManyToOne(targetEntity="Medstor\UserBundle\Entity\User")
     */
    protected $user;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUser($user):self
    {
        $this->user = $user;       
        
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}
