<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizRepo;
use App\Repository\QuestionRepo;


class TemplateController extends AbstractController
{


    /**
     * @Route("/template", name="template")
     */
    public function indexe(QuizRepo $quizrepo,QuestionRepo $questionrepo): Response
    {
        return $this->render('template/index2.html.twig', [
            'controller_name' => 'TemplateController',
            'Quiz' => $quizrepo->createQueryBuilder('u')->select('u')->getQuery()->getResult(),
            'Question' => $questionrepo->createQueryBuilder('u')->select('u')->getQuery()->getResult()


        ]);
    }

    

    /**
     * @Route("/templateback", name="templateback")
     */
    public function index(): Response
    {
        return $this->render('template/index3.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }



}
