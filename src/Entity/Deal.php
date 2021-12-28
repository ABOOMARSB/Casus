<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DealRepository::class)
 */
class Deal
{
    private const ZEROS_BEHIND_COMMA_PRICE = '00';
    private const IMGS_FIRST_URL = 'https://media.socialdeal.nl';
    private const NEW_TODAY_HTML_DIV= '<div class="newToday">NEW TODAY</div>';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $deal_unique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="integer")
     */
    private $sold;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $new_price;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $from_price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_for_sale;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_new_today;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="deals", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="deals")
     */
    private $City;

    public function __construct($deal)
    {
        $this->deal_unique = $deal['unique'];
        $this->title = $deal['title'];
        $this->slug = $deal['slug'];
        $this->img = $deal['img'];
        $this->sold = $deal['sold'];
        $this->new_price = $deal['price'];
        $this->from_price = $deal['from'];
        $this->is_for_sale = $deal['is_for_sale'];
        $this->is_new_today = $deal['is_new_today'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDealUnique(): ?string
    {
        return $this->deal_unique;
    }

    public function setDealUnique(string $deal_unique): self
    {
        $this->deal_unique = $deal_unique;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getFullImg(): ?string
    {
        $img = $this->img;
        $fullImg = self::IMGS_FIRST_URL . $img;

        return $fullImg;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getSold(): ?int
    {
        return $this->sold;
    }

    public function setSold(int $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getPriceAsHtml(): ?string
    {
        $price = $this->new_price;
        $formatted = number_format($price, 2);
        $seperate = explode(".", $formatted);

        if ($seperate[1] === self::ZEROS_BEHIND_COMMA_PRICE)
        {
            return '<div class="before"> &euro;' . $seperate[0] . '</div>';
        }
        else
        {
            return '<div class="before">&euro;' . $seperate[0] . ',</div><div class="after">' . $seperate[1] . '</div>';
        }
    }

    public function setNewPrice(string $new_price): self
    {
        $this->new_price = $new_price;

        return $this;
    }

    public function getFromPrice(): ?string
    {
        $from = $this->from_price;
        $from = number_format($from, 2, ',', '');

        return '&euro;' . $from;
    }

    public function setFromPrice(string $from_price): self
    {
        $this->from_price = $from_price;

        return $this;
    }

    public function getIsForSale(): ?bool
    {
        return $this->is_for_sale;
    }

    public function setIsForSale(bool $is_for_sale): self
    {
        $this->is_for_sale = $is_for_sale;

        return $this;
    }

    public function getIsNewToday(): ?bool
    {
        return $this->is_new_today;
    }

    public function setIsNewToday(bool $is_new_today): self
    {
        $this->is_new_today = $is_new_today;

        return $this;
    }

    public function getPercentDiscount(): float
    {
        $price = $this->new_price;
        $from = $this->from_price;
        $calculate = ($from - $price) / $from * 100;
        $discountAmount = floor($calculate);

        return $discountAmount;
    }

    public function shouldShowDiscount(): bool
    {
        return $this->getPercentDiscount() >= 1;
    }

    public function divIsNew(): string
    {
        $getNewTodayFunc = $this->getIsNewToday();
        if ($getNewTodayFunc === true)
        {
            return self::NEW_TODAY_HTML_DIV;
        }
        return $getNewTodayFunc;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function visibleCategory(): bool
    {
        $catsort = isset( $_GET['catSort'] ) ? $_GET['catSort'] : 0;
        $activeCategory = (int) htmlspecialchars($catsort);
        if( $activeCategory === 0 )
        {
            return true;
        }

        return $this->category === $activeCategory;
    }

    public function getCity(): ?City
    {
        return $this->City;
    }

    public function setCity(?City $City): self
    {
        $this->City = $City;

        return $this;
    }
}