<?php


namespace App\Controller;

use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventCreationController extends AbstractController
{

    /**
     * @Route("/events/create", name="events_create")
     * @IsGranted("ROLE_USER")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(EventType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute("events_list");
        }

        return $this->render('events/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}