<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireController extends AbstractController
{
    
 /**
     * @Route("/commentaire", name="commentaire", methods={"GET"})
     */
    public function getAll(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
        ->getRepository(Commentaire::class)
        ->findAll();
    $publications = $entityManager
        ->getRepository(Publication::class)
        ->findAll();
    return $this->render('commentaire/BlogDetails.html.twig', [
        'commentaires' => $commentaires,
        'publications' => $publications,

    ]);
    }
    /**
     * @Route("/listComment", name="Lc")
     */
    public function Luser(EntityManagerInterface $entityManager): Response
    {
        $commentaire = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();
        return $this->render('commentaire/listC_B.html.twig', [
            'controller_name' => 'PublicationController',
            'commentaire' => $commentaire,
        ]);
    }
   
}
