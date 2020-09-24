<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @ORM\Table(name="property",indexes={@ORM\Index(name="search_idx",columns={"postcode_search","house_number_or_name","unit_name"})})
 */
class Property
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $property_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $house_number_or_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unit_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $county;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="property", orphanRemoval=true)
     * @ORM\OrderBy({"date"="DESC"})
     */
    private $transactions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postcode_search;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getPropertyType(): ?string
    {
        return $this->property_type;
    }

    public function setPropertyType(string $property_type): self
    {
        $this->property_type = $property_type;
        return $this;
    }

    public function getHouseNumberOrName(): ?string
    {
        return $this->house_number_or_name;
    }

    public function setHouseNumberOrName(string $house_number_or_name): self
    {
        $this->house_number_or_name = $house_number_or_name;
        return $this;
    }

    public function getUnitName(): ?string
    {
        return $this->unit_name;
    }

    public function setUnitName(string $unit_name): self
    {
        $this->unit_name = $unit_name;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(string $locality): self
    {
        $this->locality = $locality;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;
        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(string $county): self
    {
        $this->county = $county;
        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setProperty($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getProperty() === $this) {
                $transaction->setProperty(null);
            }
        }

        return $this;
    }

    public function getPostcodeSearch(): ?string
    {
        return $this->postcode_search;
    }

    public function setPostcodeSearch(string $postcode_search): self
    {
        $this->postcode_search = $postcode_search;

        return $this;
    }
}
