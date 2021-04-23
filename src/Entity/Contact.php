<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact extends Guest
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeName;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="idContact")
     */
    private $idMission;

    protected $discr = 'contact';
    
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

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

}
