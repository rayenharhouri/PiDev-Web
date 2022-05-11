<?php

namespace App\Controller;

use App\Entity\SalleJeu;
use App\Form\SalleJeuType;
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


/**
 * @Route("/salle/jeu")
 */
class SalleJeuController extends AbstractController
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

        $repository=$this->getdoctrine()->getrepository(SalleJeu::class);
        $allCoch=$repository->findAll();

// Retrieve the HTML generated in our twig file
        $html = $this->renderView('salle_jeu/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'SalleJeu'=>$allCoch,
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
     * @Route("/", name="app_salle_jeu_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $salleJeus = $entityManager
            ->getRepository(SalleJeu::class)
            ->findAll();



        return $this->render('salle_jeu/index.html.twig', [
            'salle_jeus' => $salleJeus,
        ]);






    }
    /**
         * @Route("/user", name="app_salle_jeu_index_user", methods={"GET"})
         */
        public function index_user(EntityManagerInterface $entityManager): Response
        {
            $salleJeus = $entityManager
                ->getRepository(SalleJeu::class)
                ->findAll();

            return $this->render('salle_jeu/show_user.html.twig', [
                'salle_jeus' => $salleJeus,
            ]);
        }

    /**
     * @Route("/new", name="app_salle_jeu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salleJeu = new SalleJeu();
        $form = $this->createForm(SalleJeuType::class, $salleJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salleJeu);
            $entityManager->flush();

            return $this->redirectToRoute('app_salle_jeu_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('salle_jeu/new.html.twig', [
            'salle_jeu' => $salleJeu,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{idSallej}", name="app_salle_jeu_show", methods={"GET"})
     */
    public function show(SalleJeu $salleJeu): Response
    {
        return $this->render('salle_jeu/show.html.twig', [
            'salle_jeu' => $salleJeu,
        ]);
    }

    /**
     * @Route("/{idSallej}/edit", name="app_salle_jeu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SalleJeu $salleJeu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalleJeuType::class, $salleJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_salle_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salle_jeu/edit.html.twig', [
            'salle_jeu' => $salleJeu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idSallej}", name="app_salle_jeu_delete", methods={"POST"})
     */
    public function delete(Request $request, SalleJeu $salleJeu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salleJeu->getIdSallej(), $request->request->get('_token'))) {
            $entityManager->remove($salleJeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_salle_jeu_index', [], Response::HTTP_SEE_OTHER);
    }






















    public function getData() :array
        {
            /**
             * @var $Reclamation rec[]
             */
            $list = [];
            // $reclam = $this->entityManager->getRepository(Reclamation::class)->findAll();
            $reclam = $this->getDoctrine()->getRepository(SalleJeu::class)->findAll();

            foreach ($reclam as $rec) {
                $list[] = [
                    $rec->getIdSallej(),
                    $rec->getNomsallej(),
                    $rec->getIdTournementp()
                ];
            }
            return $list;
        }

        /**
         * @Route("/excel/exportT",  name="exportT")
         */
        public function export()
        {
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setTitle('SalleJeu List');

            $sheet->getCell('A1')->setValue('idSallej');
            $sheet->getCell('B1')->setValue('nomsallej');
            $sheet->getCell('C1')->setValue('idTournementp');



            // Increase row cursor after header write
            $sheet->fromArray($this->getData(),null, 'A2', true);
            $writer = new Xlsx($spreadsheet);
            // $writer->save('ss.xlsx');
            $writer->save('SalleJeu'.date('m-d-Y_his').'.xlsx');
            return $this->redirectToRoute('app_salle_jeu_index');

        }














}
