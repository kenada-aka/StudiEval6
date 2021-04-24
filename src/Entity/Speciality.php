<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 */
class Speciality
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Agent::class, inversedBy="specialities")
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="idSpeciality")
     */
    private $missions;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->missions = new ArrayCollection();
    }

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

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): ?Collection
    {
        return $this->missions;
    }

    public function addMissions(Mission $missions): self
    {
        if (!$this->missions->contains($missions)) {
            $this->missions[] = $missions;
            $missions->setMissions($this);
        }
        return $this;
    }

    public function removeMissions(Mission $missions): self
    {
        if ($this->missions->removeElement($missions)) {
            // set the owning side to null (unless already changed)
            if ($missions->getMissions() === $this) {
                $missions->setMissions(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgents(Agent $agents): self
    {
        if (!$this->agents->contains($agents)) {
            $this->agents[] = $agents;
            $agents->addSpecialities($this);
        }
        return $this;
    }

    public function removeAgents(Agent $agents): self
    {
        if ($this->agents->removeElement($agents)) {
            // set the owning side to null (unless already changed)
            if ($agents->getSpecialities() === $this) {
                $agents->setSpecialities(null);
            }
        }
        return $this;
    }

   

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

}
