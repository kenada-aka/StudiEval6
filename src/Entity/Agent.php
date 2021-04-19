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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeId;

    /**
     * @ORM\OneToMany(targetEntity=Speciality::class, mappedBy="idAgent")
     */
    private $specialities;

    /**
     * @ORM\OneToMany(targetEntity=Speciality::class, mappedBy="agent")
     */
    private $idSpeciality;

    protected $discr = 'agent';

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
        $this->idSpeciality = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Speciality[]
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->setIdAgent($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->removeElement($speciality)) {
            // set the owning side to null (unless already changed)
            if ($speciality->getIdAgent() === $this) {
                $speciality->setIdAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Speciality[]
     */
    public function getIdSpeciality(): Collection
    {
        return $this->idSpeciality;
    }

    public function addIdSpeciality(Speciality $idSpeciality): self
    {
        if (!$this->idSpeciality->contains($idSpeciality)) {
            $this->idSpeciality[] = $idSpeciality;
            $idSpeciality->setAgent($this);
        }

        return $this;
    }

    public function removeIdSpeciality(Speciality $idSpeciality): self
    {
        if ($this->idSpeciality->removeElement($idSpeciality)) {
            // set the owning side to null (unless already changed)
            if ($idSpeciality->getAgent() === $this) {
                $idSpeciality->setAgent(null);
            }
        }

        return $this;
    }
}
