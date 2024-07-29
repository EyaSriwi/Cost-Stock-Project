<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
//    #[Route('/contact', name: 'app_contact')]
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
