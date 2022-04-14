<?php

namespace App\Controller;

use App\Entity\Quizs;
use App\Form\QuizsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
