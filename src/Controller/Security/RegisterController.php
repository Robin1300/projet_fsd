<?php


namespace App\Controller\Security;


use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request, EntityManagerInterface $em)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }


        return $this->render('security/register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}