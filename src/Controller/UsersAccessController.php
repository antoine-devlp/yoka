<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use  Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersAccessController extends AbstractController
{
    #[Route('/', name: 'users_access')]
    public function index(): Response
    {
        return $this->render('users_access/index.html.twig', [
            'controller_name' => 'UsersAccessController',
        ]);
    }

    #[Route('/login', name: 'users_login')]
    public function indexLogin(): Response
    {
        return $this->render('users_access/login.html.twig');
    }

    #[Route('/register', name: 'users_register')]
    public function indexRegister(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $utilisateur = new Users();
        $form = $this->createForm(RegisterType::class, $utilisateur );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $passwordCrypte = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypte);
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute("users_access");
        };

        return $this->render('users_access/register.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/logout', name: 'users_logout')]
    public function indexLogout()
    {
       
    }
}
