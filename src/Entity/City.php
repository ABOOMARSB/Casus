<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
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
     * @ORM\Column(type="text")
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="City")
     */
    private $deals;

    public function __construct($city)
    {
        $this->name = $city['city_name'];
        $this->slug = $city['city_slug'];

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
            $deal->setCity($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getCity() === $this) {
                $deal->setCity(null);
            }
        }

        return $this;
    }
}
