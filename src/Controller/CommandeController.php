<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LigneCommande;
use App\Repository\LigneCommandeRepo;
//use commandeBundle\Repository\LigneCommandeRepo;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\CommandeRepo;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(): Response
    {
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     */
    public function new(Request $request, LigneCommandeRepo $LigneCommandeRepo): Response
    {
        $commande = new Commande();
        $commande->setIdU('2');
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);


        $commande->setEtat(('non traite'));


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            //////////
            $total = $commande->getQte() * $commande->getPrixTotal();

            $maxidUser = $LigneCommandeRepo->max_id_user();
            $maxidCommande = $LigneCommandeRepo->max_id_commande();

            $InsertInCommandeLigne = $LigneCommandeRepo->insert_idUser($total, $maxidUser['id'], $maxidCommande['id']);
            //////////



            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{idCommande}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{idCommande}/edit", name="commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommande}", name="commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getIdCommande(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     *@Route("/pdf/reclam", name="pdf_index", methods={"GET"})
     */
    public function pdfReclamation(CommandeRepo $crepo)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commande/pdf.html.twig', [
            'commande' =>$crepo->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }















/**
     * @Route("/{idCommande}/editetat", name="commande_editetat", methods={"GET","POST"})
     */
    public function editetat(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        $commande->setEtat(('traite'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

  










 /**
     * @Route("/e/stat", name="stat", methods={"GET"})
     */
    public function reclamation_stat(CommandeRepo $rhrepo): Response
    {
        $nbrs[]=Array();

        $e1=$rhrepo->find_Nb_Rec_Par_Status("non traite");
        dump($e1);
        $nbrs[]=$e1[0][1];


        $e2=$rhrepo->find_Nb_Rec_Par_Status("traite");
        dump($e2);
        $nbrs[]=$e2[0][1];

/*
        $e3=$activiteRepository->find_Nb_Rec_Par_Status("Diffence");
        dump($e3);
        $nbrs[]=$e3[0][1];
*/

        dump($nbrs);
        reset($nbrs);
        dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);

        $nbrss=array_values($nbrs);
        dump(json_encode($nbrss));

        return $this->render('commande/stat.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }















}
