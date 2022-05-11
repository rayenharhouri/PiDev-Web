<?php

namespace App\Controller;

use App\Entity\FiltrerProduit;
use App\Entity\Produit;
use App\Form\FiltreProduitType;
use App\Form\ProduitType;
use App\Repository\FournisseurRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="app_produit_index")
     */
    public function index(ProduitRepository $repository, Request $request): Response
    {
        $search = new FiltrerProduit();
        $form = $this->createForm(FiltreProduitType::class, $search);
        $form->handleRequest($request);
        $produits = $repository->findproduit($search);


        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{idProduit}", name="app_produit_show", methods={"GET"})
     */

    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{idProduit}/edit", name="app_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{idProduit}", name="app_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getIdProduit(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/searchProduiteajax ", name="ajaxProduit")
     */
    public function searchOffreajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $requestString=$request->get('searchValue');
        $produits = $repository->findProduitbyname($requestString);

        return $this->render('Produit/Produitajax.html.twig', [
            "produits"=>$produits
        ]);
    }

    /**
     * @Route("/stats ", name="stats")
     */
    public function statistique(FournisseurRepository $repository)
    {
        $fournisseur = $repository->findAll();
        $fournom = [];
        $fourcount=[];
        foreach ( $fournisseur as $f)
        {
            $fournom[]=$f->getNomFournisseur();
            $fourcount[]= count($f->getProduits());

        }
        return $this->render('Produit/stats.html.twig', [
            'fournom'=>json_encode($fournom),
            'fourcount'=>json_encode($fourcount)

        ]);
    }
}
