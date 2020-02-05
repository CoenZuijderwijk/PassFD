<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
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
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClothingPiece", mappedBy="user")
     */
    private $clothingPieces;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $Roles = [] ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $face_image;

    public function __construct()
    {
        $this->user_clothingPieces = new ArrayCollection();
        $this->clothingPieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return Collection|UserClothingPiece[]
     */
    public function getUserClothingPieces(): Collection
    {
        return $this->user_clothingPieces;
    }

    public function addUserClothingPiece(UserClothingPiece $userClothingPiece): self
    {
        if (!$this->user_clothingPieces->contains($userClothingPiece)) {
            $this->user_clothingPieces[] = $userClothingPiece;
            $userClothingPiece->setUser($this);
        }

        return $this;
    }

    public function removeUserClothingPiece(UserClothingPiece $userClothingPiece): self
    {
        if ($this->user_clothingPieces->contains($userClothingPiece)) {
            $this->user_clothingPieces->removeElement($userClothingPiece);
            // set the owning side to null (unless already changed)
            if ($userClothingPiece->getUser() === $this) {
                $userClothingPiece->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClothingPiece[]
     */
    public function getClothingPieces(): Collection
    {
        return $this->clothingPieces;
    }

    public function addClothingPiece(ClothingPiece $clothingPiece): self
    {
        if (!$this->clothingPieces->contains($clothingPiece)) {
            $this->clothingPieces[] = $clothingPiece;
            $clothingPiece->setUser($this);
        }

        return $this;
    }

    public function removeClothingPiece(ClothingPiece $clothingPiece): self
    {
        if ($this->clothingPieces->contains($clothingPiece)) {
            $this->clothingPieces->removeElement($clothingPiece);
            // set the owning side to null (unless already changed)
            if ($clothingPiece->getUser() === $this) {
                $clothingPiece->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->Roles;
        $roles[] = 'ROLE_USER';
        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setRoles(array $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    public function getFaceImage(): ?string
    {
        return $this->face_image;
    }

    public function setFaceImage(?string $face_image): self
    {
        $normalizer = new DataUriNormalizer();
        $face_image = $normalizer->normalize($face_image);
        $this->face_image = $face_image;

        return $this;
    }
}
