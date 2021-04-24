<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;




    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class)
     */
    private $idSpeciality;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="idMission")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Target::class, mappedBy="idMission")
     */
    private $targets;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="idMission")
     */
    private $agents;

    /**
     * @ORM\OneToOne(targetEntity=Stash::class, mappedBy="idMission")
     */
    private $idStash;

    

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->targets = new ArrayCollection();
        $this->agents = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdSpeciality(): ?Speciality
    {
        return $this->idSpeciality;
    }

    public function setIdSpeciality(?Speciality $idSpeciality): self
    {
        $this->idSpeciality = $idSpeciality;

        return $this;
    }

    public function getIdStash(): ?Stash
    {
        return $this->idStash;
    }

    public function setIdStash(Stash $idStash): self
    {
        $this->idStash = $idStash;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContacts(Contact $contacts): self
    {
        if (!$this->contacts->contains($contacts)) {
            $this->contacts[] = $contacts;
            $contacts->setContacts($this);
        }
        return $this;
    }

    public function removeContacts(Contact $contacts): self
    {
        if ($this->contacts->removeElement($contacts)) {
            // set the owning side to null (unless already changed)
            if ($contacts->getContacts() === $this) {
                $contacts->setContacts(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Target[]
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTargets(Contact $targets): self
    {
        if (!$this->targets->contains($targets)) {
            $this->targets[] = $targets;
            $targets->setTargets($this);
        }
        return $this;
    }

    public function removeTargets(Target $targets): self
    {
        if ($this->targets->removeElement($targets)) {
            // set the owning side to null (unless already changed)
            if ($targets->getTargets() === $this) {
                $targets->setTargets(null);
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
            $agents->setAgents($this);
        }
        return $this;
    }

    public function removeAgents(Agent $agents): self
    {
        if ($this->agents->removeElement($agents)) {
            // set the owning side to null (unless already changed)
            if ($agents->getAgents() === $this) {
                $agents->setAgents(null);
            }
        }
        return $this;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
    
    
}
