<?php


namespace App\Doctrine;


use App\Entity\Event;
use Symfony\Component\Security\Core\Security;

class EventUserListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Event $event): void
    {
        if (empty($event->user)) {
            $event->user = $this->security->getUser();
        }
    }
}