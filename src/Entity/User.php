<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="A user with this email already exists.")
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
    private ?int $id;

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
     * @ORM\Column(type="date")
     * @Assert\Date(message="You must provide a valid birth date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Country(message="You must provide a valid country")
     * @Assert\NotNull(message="You must provide a country")
     */
    private ?string $country;

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

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate($birthDate): self
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
