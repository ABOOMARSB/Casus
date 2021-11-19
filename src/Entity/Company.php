<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companySlug;

    /**
     * @ORM\Column(type="text")
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $zip;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=16)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=16)
     */
    private $longitude;

    /**
     * @ORM\Column(type="text")
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="company_id")
     */
    private $deal;


    public function __construct($deal)
    {
        $this->name = $deal['company_name'];
        $this->companySlug = $deal['company_slug'];
        $this->street = $deal['locations.street'];
        $this->zip = $deal['locations.zip'];
        $this->latitude = $deal['latitude'];
        $this->longitude = $deal['longitude'];
        $this->website = $deal['website'];
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

    public function getCompanySlug(): ?string
    {
        return $this->companySlug;
    }

    public function setCompanySlug(string $companySlug): self
    {
        $this->companySlug = $companySlug;

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

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection|Deal[]
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals[] = $deal;
            $deal->setCompanyId($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getCompanyId() === $this) {
                $deal->setCompanyId(null);
            }
        }

        return $this;
    }


}
