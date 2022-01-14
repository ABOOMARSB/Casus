<?php

namespace App\Entity;

use App\DealCollection;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $checkCompanySlug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="text")
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=7)
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
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="company")
     */
    private $deals;



    static function fromJsonToDB($dealJson, $dealDetail)
    {
        $company = array_merge($dealJson, $dealDetail);
        return new self($company);
    }

    public function __construct($company)
    {
        $this->name = $company['company_name'];
        $this->companySlug = $company['company_slug'];
        $this->latitude = $company['deal_map_pointer']['latitude'];
        $this->longitude = $company['deal_map_pointer']['longitude'];
        $this->website = $company['_embedded']['company']['website'];
        $this->deals = new ArrayCollection();
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
    public function getCheckCompanySlug(): ?string
    {
        return $this->checkCompanySlug;
    }

    public function setCheckCompanySlug(string $checkCompanySlug): self
    {
        $this->checkCompanySlug = $checkCompanySlug;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

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

    public function getLatLng(){
        $latLng = [ 'lat' => $this->latitude, 'lng' => $this->longitude ];
        return json_encode($latLng);
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return DealCollection|Deal[]
     */
    public function getDeals(): DealCollection
    {
        return DealCollection::fromArrayCollection($this->deals);
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals[] = $deal;
            $deal->setCompany($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getCompany() === $this) {
                $deal->setCompany(null);
            }
        }

        return $this;
    }
}
