<?php


namespace App\Controller;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventDeleteController extends AbstractController
{
    /**
     * @Route("/events/{id}/delete", name="events_delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(Event $event, EntityManagerInterface $em)
    {
        if (!$this->isGranted('CAN_REMOVE', $event)) {
            return $this->redirectToRoute("home");
        }

        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('events_list');
    }
}