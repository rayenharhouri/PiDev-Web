<?php

namespace App\Controller;

use App\Entity\Tournoi;
use App\Form\TournoiType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


use commandeBundle\Repository\TournoiRepo;

/**
 * @Route("/tournoi")
 */
class TournoiController extends AbstractController
{





/**
     * @Route("/createpdf", name="createpdf")
     */
    public function pdf(Request $request){
// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

// Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repository=$this->getdoctrine()->getrepository(Tournoi::class);
        $allCoch=$repository->findAll();

// Retrieve the HTML generated in our twig file
        $html = $this->renderView('tournoi/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'Tournoi'=>$allCoch,
        ]);

// Load HTML to Dompdf
        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A1', 'portrait');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }






































    /**
     * @Route("/", name="app_tournoi_index", methods={"GET"})
     */
    public function index(Request $request,EntityManagerInterface $entityManager, PaginatorInterface $paginator ): Response
    {


     $requestsql = $this->getDoctrine()->getRepository(Tournoi::class)->mise_a_joure();





              $donnees = $this->getDoctrine()
                                    ->getRepository(Tournoi::class)
                                    ->findBy([],['idTournoi' => 'desc']);

                                $tournois = $paginator->paginate(
                                    $donnees, // Requête contenant les données à paginer (ici nos articles)
                                    $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                                    2 // Nombre de résultats par page
                                );

        return $this->render('tournoi/index.html.twig', [
            'tournois' => $tournois,
        ]);
    }
     /**
         * @Route("/user", name="app_tournoi_index_user", methods={"GET"})
         */
        public function index_user(EntityManagerInterface $entityManager): Response
        {
          $requestsql = $this->getDoctrine()->getRepository(Tournoi::class)->mise_a_joure();

            $tournois = $entityManager
                ->getRepository(Tournoi::class)
                ->findAll();

            return $this->render('tournoi/show_user.html.twig', [
                'tournois' => $tournois,
            ]);
        }

    /**
     * @Route("/new", name="app_tournoi_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tournoi = new Tournoi();
        $form = $this->createForm(TournoiType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tournoi);
            $entityManager->flush();

            return $this->redirectToRoute('app_tournoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournoi/new.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTournoi}", name="app_tournoi_show", methods={"GET"})
     */
    public function show(Tournoi $tournoi): Response
    {
        return $this->render('tournoi/show.html.twig', [
            'tournoi' => $tournoi,
        ]);
    }

    /**
     * @Route("/{idTournoi}/edit", name="app_tournoi_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tournoi $tournoi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TournoiType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tournoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournoi/edit.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTournoi}", name="app_tournoi_delete", methods={"POST"})
     */
    public function delete(Request $request, Tournoi $tournoi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournoi->getIdTournoi(), $request->request->get('_token'))) {
            $entityManager->remove($tournoi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tournoi_index', [], Response::HTTP_SEE_OTHER);
    }



















    public function getData() :array
        {
            /**
             * @var $Reclamation rec[]
             */
            $list = [];
            // $reclam = $this->entityManager->getRepository(Reclamation::class)->findAll();
            $reclam = $this->getDoctrine()->getRepository(Tournoi::class)->findAll();

            foreach ($reclam as $rec) {
                $list[] = [
                    $rec->getIdTournoi(),
                    $rec->getNombreEquipe(),
                    $rec->getDate(),
                    $rec->getTypeJeu(),
                    $rec->getPrix()

                ];
            }
            return $list;
        }

        /**
         * @Route("/excel/export",  name="export")
         */
        public function export()
        {
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setTitle('Tournoi List');

            $sheet->getCell('A1')->setValue('idTournoi');
            $sheet->getCell('B1')->setValue('nombreEquipe');
            $sheet->getCell('C1')->setValue('date');
            $sheet->getCell('D1')->setValue('typeJeu');



            // Increase row cursor after header write
            $sheet->fromArray($this->getData(),null, 'A2', true);
            $writer = new Xlsx($spreadsheet);
            // $writer->save('ss.xlsx');
            $writer->save('Tournoi'.date('m-d-Y_his').'.xlsx');
            return $this->redirectToRoute('app_tournoi_index');

        }



















}
