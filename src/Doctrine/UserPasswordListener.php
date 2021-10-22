<?php


namespace App\Doctrine;


use App\Entity\User;
use Doctrine\Common\EventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordListener
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->encoder = $userPasswordEncoder;
    }
    public function prePersist(User $entity, LifecycleEventArgs $eventArgs)
    {
        $hash = $this->encoder->encodePassword($entity, $entity->password);
        $entity->password = $hash;
    }
}