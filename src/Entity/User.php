<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("email", message = "Cet email est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message = "L'email ne doit pas être vide")
     * @Assert\Email(message = "L'email doit être un email valide")
     * @Assert\Length(max = 255, maxMessage = "L'email ne doit pas depasser {{ limit }} caractères")
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le prénom ne doit pas être vide")
     * @Assert\Length(max = 255, maxMessage = "Le prénom ne doit pas depasser {{ limit }} caractères")
     */
    public $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le nom ne doit pas être vide")
     * @Assert\Length(max = 255, maxMessage = "Le nom ne doit pas depasser {{ limit }} caractères")
     */
    public $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le mot de passe ne doit pas être vide")
     * @Assert\Length(max = 255, maxMessage = "Le mot de passe ne doit pas depasser {{ limit }} caractères")
     */
    public $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="user")
     */
    public $events;

    /**
     * @ORM\Column(type="array")
     */
    public $roles = [];
    /**
     * @var string[]
     */

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function initializeCreatedAt()
    {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getFullName()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array_merge(['ROLE_USER'], $this->roles);
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}