<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
//    #[Route('/signup', name: 'app_signup')]
    /**
     * @Route("/signup", name="app_signup")
     */
    public function signup(): Response
    {
        return $this->render('front/signup.html.twig', [
            'controller_name' => 'SignupController',
        ]);
    }
}