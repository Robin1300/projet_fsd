<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom est obligatoire")
     * @Assert\Length(max = 255, maxMessage = "Le nom ne doit pas depasser {{ limit }} caractères")
     */
    public $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Une date est obligatoire")
     */
    public $date;

    /**
     * @ORM\Column(type="datetime")
     */
    public $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     */
    public $user;

    /**
     * @ORM\Column(type="string", length=555, nullable=true)
     * @Assert\Length(max = 555, maxMessage = "La descrition ne doit pas depasser {{ limit }} caractères")
     */
    public $description;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

}