<?php


namespace App\Controller;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventListController extends AbstractController
{
    /**
     * @Route("/events", name="events_list")
     * @IsGranted("ROLE_USER")
     */
    public function list(EventRepository $eventRepository, EntityManagerInterface $entityManager):Response
    {

        if ($this->isGranted('CAN_LIST_ALL_EVENTS')) {
            $events = $eventRepository->findAll();
        } else {
            $events = $eventRepository->findEventsForUser($this->getUser());
        }

        return $this->render("events/list.html.twig", [
            'events' => $events
        ]);
    }

}