<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $contact;

    /**
     * @ORM\OneToOne(targetEntity=Target::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $target;

    /**
     * @ORM\OneToOne(targetEntity=Agent::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $agent;

    /**
     * @ORM\OneToOne(targetEntity=Admin::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $admin;

    /**
     * @ORM\OneToOne(targetEntity=Guest::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $guest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        // set the owning side of the relation if necessary
        if ($contact->getIdUser() !== $this) {
            $contact->setIdUser($this);
        }

        $this->contact = $contact;

        return $this;
    }

    public function getTarget(): ?Target
    {
        return $this->target;
    }

    public function setTarget(Target $target): self
    {
        // set the owning side of the relation if necessary
        if ($target->getIdUser() !== $this) {
            $target->setIdUser($this);
        }

        $this->target = $target;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(Agent $agent): self
    {
        // set the owning side of the relation if necessary
        if ($agent->getIdUser() !== $this) {
            $agent->setIdUser($this);
        }

        $this->agent = $agent;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        // set the owning side of the relation if necessary
        if ($admin->getIdUser() !== $this) {
            $admin->setIdUser($this);
        }

        $this->admin = $admin;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(Guest $guest): self
    {
        // set the owning side of the relation if necessary
        if ($guest->getIdUser() !== $this) {
            $guest->setIdUser($this);
        }

        $this->guest = $guest;

        return $this;
    }
}
