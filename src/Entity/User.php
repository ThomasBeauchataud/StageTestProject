<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Service\User\ConstraintUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ConstraintUniqueEmail
 */
class User
{

    CONST GENDER_MALE = "Male";
    CONST GENDER_FEMALE = "Female";
    CONST GENDERS = array(self::GENDER_FEMALE, self::GENDER_MALE);

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="You must provide a name")
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="You must provide a surname")
     */
    private ?string $surname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="The email '{{ value }}' is not a valid email.")
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice({"Male", "Female"}, message="You must provide a valid gender")
     */
    private ?string $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Date(message="You must provide a valid birth date")
     */
    private ?string $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="You must provide a country")
     */
    private ?string $country;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
