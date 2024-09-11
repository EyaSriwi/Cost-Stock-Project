<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Edit user details.
     *
     * @Route("/user/edit/{id}", name="user.edit", methods={"GET", "POST"})
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        // Ensure the current user is logged in
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        // Ensure the current user is editing their own profile
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Persist and flush changes to the user entity
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your account information has been changed');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('front/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Change user password.
     *
     * @Route("/user/editPassword/{id}", name="user.edit.password", methods={"GET", "POST"})
     */
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $plainPassword = $data['plainPassword'];
            $newPassword = $data['newPassword'];

            // Check if the current password is valid
            if ($hasher->isPasswordValid($user, $plainPassword)) {
                // Hash and set the new password
                $user->setPassword($hasher->hashPassword($user, $newPassword));

                // Persist and flush changes to the user entity
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Your password has been changed');
                return $this->redirectToRoute('app_index');
            } else {
                $this->addFlash('warning', 'Your current password is incorrect');
            }
        }

        return $this->render('front/user/editpassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
