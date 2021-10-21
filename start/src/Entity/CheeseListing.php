<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CheeseListingRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CheeseListingRepository::class)
 */
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get',
        'put',
    ],
    shortName: 'cheeses',
    denormalizationContext: [
        'groups' => ['cheese_listing:write'],
        'swagger_definition_name' => 'Write'
    ],
    normalizationContext: [
        'groups' => ['cheese_listing:read'],
        'swagger_definition_name' => 'Read'
    ]
)]
class CheeseListing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cheese_listing:read", "cheese_listing:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"cheese_listing:read"})
     */
    private $description;

    /**
     * The price of this delicious cheese, in cents
     *
     * @ORM\Column(type="integer")
     * @Groups({"cheese_listing:read", "cheese_listing:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

    public function __construct()
    {

        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {

        return $this->id;
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

    public function getDescription(): ?string
    {

        return $this->description;
    }


    public function setDescription(string $description): self
    {

        $this->description = nl2br($description);

        return $this;
    }

    /**
     * The description of the cheese as raw text.
     *
     * @Groups({"cheese_listing:write"})
     */
    public function setTextDescription(string $description): self
    {

        $this->description = nl2br($description);

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {

        return $this->createdAt;
    }

    /**
     * How long in text that this cheese listing was added
     *
     * @Groups({"cheese_listing:read"})
     */
    public function getCreatedAtAgo(): string
    {

        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {

        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {

        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {

        $this->isPublished = $isPublished;

        return $this;
    }

}
