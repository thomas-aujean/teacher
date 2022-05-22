<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkshopRepository::class)
 */
class Workshop
{

    public const TYPE_LITTLE  = 'little';
    public const TYPE_CYCLE2 = 'cycle2';
    public const TYPE_CYCLE3 = 'cycle3';
    public const TYPE_MIDDLE = 'middle';
    public const TYPE_SPOKEN = 'spoken';

    public const TYPES_NAMES = [
        self::TYPE_LITTLE => "Little Ones / Les Petits",
        self::TYPE_CYCLE2 => "Cycle 2",
        self::TYPE_CYCLE3 => "Cycle 3",
        self::TYPE_MIDDLE => "Middle School / Collège prep",
        self::TYPE_SPOKEN => "Spoken English / Anglais parlé"
    ];
    

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @ORM\Column(type="date")
     */
    private $end;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $enroled;

  

    /**
     * @ORM\ManyToMany(targetEntity=WorkshopChoice::class, mappedBy="workshop")
     */
    private $workshopChoices;


    public function __construct()
    {
        $this->workshopChoices = new ArrayCollection();
        $this->enroled = 0;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getMaximum(): ?int
    {
        return $this->maximum;
    }

    public function setMaximum(int $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function getEnroled(): ?int
    {
        return $this->enroled;
    }

    public function setEnroled(int $enroled): self
    {
        $this->enroled = $enroled;

        return $this;
    }


    /**
     * @return Collection<int, WorkshopChoice>
     */
    public function getWorkshopChoices(): Collection
    {
        return $this->workshopChoices;
    }

    public function addWorkshopChoice(WorkshopChoice $workshopChoice): self
    {
        if (!$this->workshopChoices->contains($workshopChoice)) {
            $this->workshopChoices[] = $workshopChoice;
            $workshopChoice->addWorkshop($this);
        }

        return $this;
    }

    public function removeWorkshopChoice(WorkshopChoice $workshopChoice): self
    {
        if ($this->workshopChoices->removeElement($workshopChoice)) {
            $workshopChoice->removeWorkshop($this);
        }

        return $this;
    }

 
}