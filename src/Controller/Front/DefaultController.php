<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
//    [Route('/index', name: 'app_index')]
    /**
     * @Route("/index", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [

        ]);
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about(): Response
    {
        return $this->render('front/about.html.twig', [

        ]);
    }

    /**
     * @Route("/service", name="app_service")
     */
    public function service(): Response
    {
        return $this->render('front/service.html.twig', [
        ]);
    }
}
