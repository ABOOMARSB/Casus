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
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="city_id")
     */
    private $deal;

    /**
     * @ORM\ManyToOne(targetEntity=Deal::class, inversedBy="cityId")
     */
    private $getDeal;

    public function __construct($deal)
    {
        $this->name = $deal['city_name'];
    }

//    public function getDeal(): ?Deal
//    {
//        return $this->getDeal;
//    }
//
//    public function setDeal(?Deal $getDeal): self
//    {
//        $this->getDeal = $getDeal;
//
//        return $this;
//    }

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


}
