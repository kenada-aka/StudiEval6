<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
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
    private $codeName;

    /**
     * @ORM\OneToOne(targetEntity=Guest::class, inversedBy="contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idGuest;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idMission;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    public function getIdGuest(): ?Guest
    {
        return $this->idGuest;
    }

    public function setIdGuest(User $idGuest): self
    {
        $this->idGuest = $idGuest;

        return $this;
    }

    public function getIdMission(): ?Mission
    {
        return $this->idMission;
    }

    public function setIdMission(Mission $idMission): self
    {
        $this->idMission = $idMission;

        return $this;
    }

}
