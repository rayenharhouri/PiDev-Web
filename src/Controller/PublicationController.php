<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Front(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
        /**
     * @Route("/admin", name="admin")
     */
    public function back(): Response
    {
        return $this->render('baseAdmin.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
   /**
     * @Route("/publication", name="publication")
     */
    public function index(): Response
    {
        return $this->render('publication/Blog.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
    

    /**
     * @Route("/AddPub",name="addPub")
     */
    public function addPub(Request $request){
        $publication = new Publication();
        
    }
}
