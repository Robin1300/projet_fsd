<?php


namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    /**
     * @Route("/admin/all_users", name="users_list_all")
     * @IsGranted("ROLE_ADMIN") or ("ROLE_MODERATOR")
     */
    public function listAll(UserRepository $userRepository, EntityManagerInterface $entityManager):Response
    {

        $users = $userRepository->findAll();

        return $this->render("admin/list_all_users.html.twig", [
            'users' => $users
        ]);
    }
}