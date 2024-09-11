<?php

namespace App\Controller\Admin;
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [

        ]);
    }

    /**
     * @Route("/predict", name="app_pred")
     */
    public function prediction(): Response
    {
        return $this->render('admin/prediction.html.twig', [

        ]);
    }

    /**
     * @Route("/userdash", name="app_user")
     */
    public function user(): Response
    {
        return $this->render('admin/user.html.twig', [

        ]);
    }
}
