<?php


namespace App\Controller;


use App\Repository\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER")
     */
    public function index(EventRepository $eventRepository)
    {
        $incomingEvents = $eventRepository->findIncomingEvent($this->getUser());

        return $this->render('home/index.html.twig', [
            'incomingEvents' => $incomingEvents
        ]);
    }

}