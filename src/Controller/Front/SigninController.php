<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SigninController extends AbstractController
{


    /**
     * @Route("/signin", name="app_signin")
     */
    public function signin(): Response
    {
        return $this->render('Front/signin.html.twig', [
            'controller_name' => 'SigninController',
        ]);
    }
}
