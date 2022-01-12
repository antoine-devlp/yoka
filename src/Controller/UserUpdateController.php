<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\PswUpdateType;
use App\Form\UpdateUsernameType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserUpdateController extends AbstractController
{
    #[Route('/update/{id}', name: 'user_update')]
    public function userUpdate(Users $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {

        $form = $this->createForm(UpdateUsernameType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $username = $form['username']->getData();
            $user->setUsername($username);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Pseudo modifié');
            return $this->redirectToRoute('users_access');
        }


        return $this->render('user_update/username_update.html.twig', ["form" => $form->createView()]);
    }



    #[Route('/psw/update/{id}', name: 'psw_update')]
    public function pswUpdate(Users $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(PswUpdateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordCrypte = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordCrypte);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Edition Utilisateur avec succés');
            return $this->redirectToRoute("users_access");
        };

        return $this->render('user_update/psw_update.html.twig', ["form" => $form->createView()]);
    }

    #[Route('delete/{id}', name: 'user_delete')]
    public function deleteUser($id, UsersRepository $repository, EntityManagerInterface $em): Response
    {
        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();

        $em = $this->getDoctrine()->getManager();

        $user = $repository->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('users_access');
    }
}
