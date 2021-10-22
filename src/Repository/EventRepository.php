<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Event;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Event::class);
    }

    public function findEventsForUser(User $user, int $maxResults = null, string $order = null, string $direction = null)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.user = :user')
            ->setParameter(':user', $user);

        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        if ($order) {
            $qb->orderBy("e." . $order, $direction);
        }

        return $qb->getQuery()
            ->getResult();
    }

    public function findPastEvent(User $user, int $maxResults = 5)
    {
        $now = date('Y-m-d H:i:s');
        return $this->createQueryBuilder('e')
            ->select('e.date, e.name, e.id, e.description')
            ->where('e.user = :user')
            ->andWhere('e.date < :now')
            ->setParameter(':now', $now)
            ->setParameter(':user', $user)
            ->orderBy('e.date', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }

    public function findIncomingEvent(User $user, int $maxResults = 5)
    {
        $now = date('Y-m-d H:i:s');
        return $this->createQueryBuilder('e')
            ->select('e.date, e.name, e.id, e.description')
            ->where('e.user = :user')
            ->andWhere('e.date > :now')
            ->setParameter(':now', $now)
            ->setParameter(':user', $user)
            ->orderBy('e.date')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }

    public function listAllEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('e.date, e.name, e.id')
            ->orderBy('e.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}