<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez donner un nom à votre produit")
     * @Assert\Length(max = 255, maxMessage="Veuillez limiter le nom de votre produit à 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez donner un nom à votre lot")
     * @Assert\Length(max = 255, maxMessage="Veuillez limiter votre lot à 255 caractères")
     */
    private $bundle;

    /**
     * @ORM\Column(type="float")
     * @Assert\Regex(
     *     "/(\d+[\.\,]\d{1,2})/",
     *     message="Veuillez entrer un prix"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="Veuillez donner une description")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255, maxMessage="Veuillez limiter ce champs à 255 caractères")
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 255)
     * @Assert\File(
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif" },
     *     maxSize="5120K",
     *     mimeTypesMessage="Veuillez choisir un fichier de type .jpg, .jpeg, .png ou .gif",
     *     maxSizeMessage="Veuillez choisir un fichier de 5Mo maximum"
     * )
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isShowcased;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAvailable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBundle(): ?string
    {
        return $this->bundle;
    }

    public function setBundle(string $bundle): self
    {
        $this->bundle = $bundle;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIsShowcased(): ?bool
    {
        return $this->isShowcased;
    }

    public function setIsShowcased(bool $isShowcased): self
    {
        $this->isShowcased = $isShowcased;

        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
