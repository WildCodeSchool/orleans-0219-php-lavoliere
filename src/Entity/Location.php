<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un nom")
     * @Assert\Length(max="255", maxMessage="Veuillez saisir un nom inférieur à {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir une adresse")
     * @Assert\Length(max="255", maxMessage="Veuillez saisir une adresse inférieur à {{ limit }} caractères")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank(message="Veuillez saisir un code postal")
     * @Assert\Length(max="6", maxMessage="Veuillez saisir un code postal valide")
     * @Assert\Regex(pattern="/\d+/", message="Veuillez saisir un code postal valide")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir une ville")
     * @Assert\Length(max="255", maxMessage="Veuillez saisir une ville inférieur à {{ limit }} caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un jour de livraison")
     * @Assert\Length(max="255", maxMessage="Veuillez saisir un jour valide")
     */
    private $delivery_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPrivate;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDeliveryDate(): ?string
    {
        return $this->delivery_date;
    }

    public function setDeliveryDate(string $delivery_date): self
    {
        $this->delivery_date = $delivery_date;

        return $this;
    }

    public function getIsPrivate(): ?string
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(string $isPrivate): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }
}
