<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**###########################
     * <----Section Admin-------->
     */###########################
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
     * @Route("/listUsers", name="Luser")
     */
    public function Luser(): Response
    {
        return $this->render('listPub_B.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
    /**###########################
     * <------Section UI--------->
     */###########################
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
     * @Route("/addP", name="addP")
     */
    function Add(Request $request){
        $pub=new Publication();
        $form=$this->createform(PubType::class,$pub);
        $form->add('Add New ', SubmitType::class,[
            'attr' => [
                'class'=>'btn btn-info waves-effect waves-light',
                'style'=>'margin-left : 50px '
            ]
        ]) ;
        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager() ; 
            $em->persist($pub) ; 
            $em->flush() ; 
            return $this->redirectToRoute('publicite') ; //lien

        } 

        return $this->render("pub_back/Add.html.twig", [
            'form' => $form->createView()
        ]) ;

   }
}
