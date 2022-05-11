<?php

namespace App\Controller;

use App\Entity\Quizs;
use App\Form\QuizsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\QuizRepo;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Groups;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/quizs")
 */
class QuizsController extends AbstractController
{
    /**
     * @Route("/", name="quizs_index", methods={"GET"})
     */
    public function index(): Response
    {
        $quizs = $this->getDoctrine()
            ->getRepository(Quizs::class)
            ->findAll();

        return $this->render('quizs/index.html.twig', [
            'quizs' => $quizs,
        ]);
    }
    /**
     * @Route("/listQuizsJSON", name="listQuizsJSON", methods={"GET"})
     */
    public function listquizsJSON(NormalizerInterface $Normalizer , QuizRepo $qrepo)

    {
        $quizs= $qrepo->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $Normalizer->normalize($quizs, 'json',['groups'=>'posts:read']);


        return new JsonResponse($formatted);
    }

    /**
     * @Route("/addQuizsJSON/new", name="addQuizsJSON")
     */
    public function addQuizsJSON(Request $request, NormalizerInterface $Normalizer)
    {
        $quizs = new Quizs();

        $quizs->setImage($request->get('image'));
        $quizs->setMatiere($request->get('matiere'));
        $quizs->setDifficulte($request->get('difficulte'));
        $quizs->setResultat($request->get('resultat'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($quizs);
        $em->flush();
        $formatted= $Normalizer->normalize($quizs, 'json',['groups'=>'post:read']);
        return new JsonResponse($formatted);
    }


    /**
     * @Route("/updateQuizsJSON/{id_quizs}", name="updateQuizsJSON")
     */
    public function updateQuizsJSON(Request $request, NormalizerInterface $Normalizer,$id_quizs)
    {
        $quizs = $this->getDoctrine()->getRepository(Quizs::class)->find($id_quizs);

        $quizs->setImage($request->get('image'));
        $quizs->setMatiere($request->get('matiere'));
        $quizs->setDifficulte($request->get('difficulte'));
        $quizs->setResultat($request->get('resultat'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($quizs);
        $em->flush();
        $formatted= $Normalizer->normalize($quizs, 'json',['groups'=>'post:read']);
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/deleteQuizsJSON/{id_quizs}", name="deleteQuizsJSON")
     */
    public function deleteQuizsJSON(Request $request, NormalizerInterface $Normalizer,$id_quizs)
    {
        $quizs = $this->getDoctrine()->getRepository(Quizs::class)->find($id_quizs);

        $em = $this->getDoctrine()->getManager();

        $em->remove($quizs);
        $em->flush();
        $formatted= $Normalizer->normalize($quizs, 'json',['groups'=>'post:read']);
        return new JsonResponse("quiz a ete supprime avec succes".json_encode($formatted));;

    }
    /**
     * @Route("/new", name="quizs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quiz = new Quizs();
        $form = $this->createForm(QuizsType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form->get('image')->getData();
            if ($file !== null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                    // ... handle exception if something happ
                    
                }
                $quiz->setImage($fileName);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('quizs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quizs/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idQuizs}", name="quizs_show", methods={"GET"})
     */
    public function show(Quizs $quiz): Response
    {
        return $this->render('quizs/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }











    /**
     * @Route("/{idQuizs}/edit", name="quizs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quizs $quiz): Response
    {
        $form = $this->createForm(QuizsType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                

            $file = $form->get('image')->getData();
            if ($file !== null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                    // ... handle exception if something happ
                    
                }
                $quiz->setImage($fileName);
            }



            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quizs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quizs/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idQuizs}", name="quizs_delete", methods={"POST"})
     */
    public function delete(Request $request, Quizs $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getIdQuizs(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quizs_index', [], Response::HTTP_SEE_OTHER);
    }


















    public function getData() :array
    {
        /**
         * @var $Restaurant Resta[]
         */
        $list = [];

        $Restauranttttt = $this->getDoctrine()->getRepository(Quizs::class)->findAll();

        foreach ($Restauranttttt as $Resta) {
            $list[] = [
                $Resta->getIdQuizs(),
                $Resta->getMatiere(),
                $Resta->getDifficulte(),
                $Resta->getResultat(),
        

            ];
        }
        return $list;
    }


    /**
     * @Route("/quiz/export",  name="export_quiz")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Reservation List');

        $sheet->getCell('A1')->setValue('idQuizs');
        $sheet->getCell('B1')->setValue('matiere');
        $sheet->getCell('C1')->setValue('difficulte');
        $sheet->getCell('D1')->setValue('resultat');
       


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(),null, 'A2', true);
        $writer = new Xlsx($spreadsheet);
        // $writer->save('ss.xlsx');
        $writer->save('Quizs'.date('m-d-Y_his').'.xlsx');
        return $this->redirectToRoute('quizs_index');

    }














    /**
     * @Route("/e/statquiz", name="statquiz", methods={"GET"})
     */
    public function reclamation_stat(QuizRepo $rhrepo): Response
    {
        $nbrs[]=Array();

        $e1=$rhrepo->find_Nb_Rec_Par_Status("Facile");
        dump($e1);
        $nbrs[]=$e1[0][1];


        $e2=$rhrepo->find_Nb_Rec_Par_Status("Difficile");
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

        return $this->render('quizs/stat.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }









    /**
     * @Route("/r/search_quizs", name="search_quizs", methods={"GET"})
     */
    public function search_usere(Request $request,NormalizerInterface $Normalizer,QuizRepo $qrepo ): Response
    {

        $requestString=$request->get('searchValue');
        $requestString3=$request->get('orderid');
        //dump($requestString);
        // dump($requestString2);
        $user = $qrepo->findUser($requestString,$requestString3);
        //dump($Hotel);
        $jsoncontentc =$Normalizer->normalize($user,'json',['groups'=>'posts:read']);
        //  dump($jsoncontentc);
        $jsonc=json_encode($jsoncontentc);
        //   dump($jsonc);
        if(  $jsonc == "[]" ) { return new Response(null); }
        else{ return new Response($jsonc); }

    }
















}
