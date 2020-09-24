<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @UniqueEntity("reference")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $new;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $tenure;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getTenure(): ?string
    {
        return $this->tenure;
    }

    public function setTenure(string $tenure): self
    {
        $this->tenure = $tenure;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }
}
