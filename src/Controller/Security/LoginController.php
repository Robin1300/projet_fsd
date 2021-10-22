<?php


namespace App\Controller\Security;



use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginForm(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);

        return  $this->render('security/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $request->get('login.error')
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}