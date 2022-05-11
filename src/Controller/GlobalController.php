<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    /**
     * @Route("/azeazezae", name="global")
     */
    public function index(): Response
    {
        return $this->render('global/indexback.html.twig');
    }

    /**
     * @Route("/", name="acceuil")
     */
    public function indexfront(): Response
    {
        return $this->render('page_acceuil.html.twig');
    }
}
