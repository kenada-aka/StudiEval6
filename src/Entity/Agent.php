<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent extends Guest
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeId;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, mappedBy="agents")
     */
    private $specialities;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="agents")
     */
    private $idMission;

    

    protected $discr = 'agent';
    

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
    }


    public function getCodeId(): ?string
    {
        return $this->codeId;
    }

    public function setCodeId(string $codeId): self
    {
        $this->codeId = $codeId;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(User $idUser): self
    {
        $this->idUser = $idUser;

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

    /**
     * @return Collection|Speciality[]
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpecialities(Speciality $specialities): self
    {
        if (!$this->specialities->contains($specialities)) {
            $this->specialities[] = $specialities;
            $specialities->addAgents($this);
        }
        return $this;
    }

    public function removeSpecialities(Speciality $specialities): self
    {
        if ($this->specialities->removeElement($specialities)) {
            // set the owning side to null (unless already changed)
            if ($specialities->getAgents() === $this) {
                $specialities->setAgents(null);
            }
        }
        return $this;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

}
