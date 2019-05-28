<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotNull
     * @Assert\Length(max = 50)
     */
    private $name;

    /**
     *@Assert\NotNull
     *@Assert\Email(message = "Veuillez fournir une adresse Mail valide")
     *@Assert\Length(max = 100)
     */
    private $mail;

    /**
     * @Assert\Regex(
     *     "/^\+33\(0\)[0-9]*$/",
     *     message="Veuillez entrer un numéro de téléphone valide"
     * )
     */
    private $phone;

    /**
     * @Assert\Length(max = 1000, maxMessage="Veuillez limiter votre objet à 100 caractères")
     */
    private $object;

    /**
     * @Assert\NotNull
     * @Assert\Length(max = 1000, maxMessage="Veuillez limiter votre message à 1000 caractères")
     */
    private $message;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
