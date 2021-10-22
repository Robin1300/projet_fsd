<?php


namespace App\Controller;


use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventEditionController extends AbstractController
{

    /**
     * @Route("/events/{id}/edit", name="events_edit")
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Event $event, EntityManagerInterface $em)
    {
        if (!$this->isGranted('CAN_EDIT', $event)) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("events_list");
        }

        return $this->render("events/edit.html.twig", [
            'form' => $form->createView()
        ]);
    }
}