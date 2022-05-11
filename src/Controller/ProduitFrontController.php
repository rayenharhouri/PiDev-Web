<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitFrontController extends AbstractController
{
    /**
     * @Route("/produit/front", name="app_produit_front")
     */
    public function index(ProduitRepository $repository , PaginatorInterface $paginator,Request $request): Response
    {
        $produits = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('produit_front/indexFront.html.twig', [
           'produit'=>$produits
        ]);
    }
}
