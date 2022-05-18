<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{

    public const STATUS_PENDING = 'pending';
    public const STATUS_VALIDATED = 'validated';


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
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $twoWeeks;

    /**
     * @ORM\ManyToOne(targetEntity=Workshop::class, inversedBy="inscriptions")
     */
    private $workshop;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="inscriptions")
     */
    private $contact;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function __construct()
    {
        date_default_timezone_set( 'Europe/Paris' );
        $this->status  = self::STATUS_PENDING;
        $this->created = new DateTime();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isTwoWeeks(): ?bool
    {
        return $this->twoWeeks;
    }

    public function setTwoWeeks(bool $twoWeeks): self
    {
        $this->twoWeeks = $twoWeeks;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): self
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
