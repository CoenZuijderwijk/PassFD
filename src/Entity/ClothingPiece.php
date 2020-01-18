<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClothingPieceRepository")
 */
class ClothingPiece
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Size;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Style;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageFileName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clothingPieces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->userClothingPieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->Size;
    }

    public function setSize(string $Size): self
    {
        $this->Size = $Size;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(string $Color): self
    {
        $this->Color = $Color;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->Style;
    }

    public function setStyle(string $Style): self
    {
        $this->Style = $Style;

        return $this;
    }

    /**
     * @return Collection|UserClothingPiece[]
     */
    public function getUserClothingPieces(): Collection
    {
        return $this->userClothingPieces;
    }

    public function addUserClothingPiece(UserClothingPiece $userClothingPiece): self
    {
        if (!$this->userClothingPieces->contains($userClothingPiece)) {
            $this->userClothingPieces[] = $userClothingPiece;
            $userClothingPiece->setClothingPiece($this);
        }

        return $this;
    }

    public function removeUserClothingPiece(UserClothingPiece $userClothingPiece): self
    {
        if ($this->userClothingPieces->contains($userClothingPiece)) {
            $this->userClothingPieces->removeElement($userClothingPiece);
            // set the owning side to null (unless already changed)
            if ($userClothingPiece->getClothingPiece() === $this) {
                $userClothingPiece->setClothingPiece(null);
            }
        }

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(string $imageFileName): self
    {
        $this->imageFileName = $imageFileName;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
