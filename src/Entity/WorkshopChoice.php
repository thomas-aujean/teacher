<?php

namespace App\Entity;

use App\Repository\WorkshopChoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkshopChoiceRepository::class)
 */
class WorkshopChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


      /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="workshop")
     */
    private $inscriptions;
    
    /**
     * @ORM\ManyToMany(targetEntity=Workshop::class, inversedBy="workshopChoices")
     */
    private $workshops;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->workshops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Workshop>
     */
    public function getWorkshops(): Collection
    {
        return $this->workshops;
    }


    public function getFirstWorkshop(): ?Workshop
    {
        return $this->workshops[0];
    }

    public function addWorkshop(Workshop $workshop): self
    {
        if (!$this->workshop->contains($workshop)) {
            $this->workshop[] = $workshop;
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        $this->workshop->removeElement($workshop);

        return $this;
    }

    
    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setWorkshopChoice($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getWorkshopChoice() === $this) {
                $inscription->setWorkshopChoice(null);
            }
        }

        return $this;
    }
}