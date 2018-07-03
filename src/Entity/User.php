<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 45,
     *      minMessage = "This field must be at least {{ limit }} characters long",
     *      maxMessage = "This field cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Regex(
     *     pattern     = "/^[A-Za-z0-9_]+$/"
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=100, nullable=false)     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "This field must be at least {{ limit }} characters long",
     *      maxMessage = "This field cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Regex(
     *     pattern     = "/^([A-Za-z]{0}?[A-Za-z\']+[\s])+([A-Za-z]{0}?[A-Za-z\'])+[\s]?([A-Za-z]{0}?[A-Za-z\'])?$/"
     * )
     *
     * @Assert\Regex(
     *     pattern   = "/\d/",
     *     match     = false,
     *     message   = "Your name cannot contain a number"
     * )
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 6,
     *      max = 64,
     *      minMessage = "Your Password must be at least {{ limit }} characters long",
     *      maxMessage = "Your Password cannot be longer than {{ limit }} characters"
     * )
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


}
