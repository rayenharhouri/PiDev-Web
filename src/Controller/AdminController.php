<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Utilisateur;
use App\Form\EditEquipeType;
use App\Form\EditUserType;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mime\Address;


/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * Affichage de la liste des Utilisateurs
     *
     * @Route("/admins", name="admins")
     */
    public function adminList(UtilisateurRepository $user){
        return $this->render("admin/admins.html.twig", [
            'user' => $user->findAll()
        ]);
    }

    /**
     * Affichage de la liste des Utilisateurs
     *
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function clientList(UtilisateurRepository $user,Request $request){
        $form =$this->createFormBuilder(null)
            ->add('S' , TextType::class)
            ->add('Recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $var = $form->get('S')->getData();
            return $this->render("admin/utilisateurs.html.twig", [
                'searchform' => $form->createView(),
                'user' => $user->search($var)
            ]);

        }
        return $this->render("admin/utilisateurs.html.twig", [
            'searchform' => $form->createView(),
            'user' => $user->findAll()
        ]);
    }

    /**
     * Affichage de la liste des Utilisateurs
     *
     * @Route("/employees", name="employees")
     */
    public function specList(UtilisateurRepository $user){
        return $this->render("admin/employees.html.twig", [
            'user' => $user->findAll()
        ]);
    }

    /**
     * Modifier un Utilisateur
     * @Route("/utilisateur/modifier/{id}/{route}", name="modifier_utilisateur")
     */
    public function editUser($route , Utilisateur $Utilisateur, Request $request){
        $form = $this -> createForm(EditUserType::class, $Utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /*$file = $Utilisateur->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){

            }
            $Utilisateur->setImage($fileName);*/
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Utilisateur);
            $entityManager->flush();

            if($route == 'admin_utilisateurs' ){
                return $this->redirectToRoute('admin_utilisateurs');
            }elseif ($route == 'admin_employees' ){
                return $this->redirectToRoute('admin_employees');
            }else{
                return $this->redirectToRoute('admin_admins');
            }
        }

        return $this->render('admin/edituser.html.twig' , [
            'UtilisateurForm' => $form ->createView()
        ]);
    }

    /**
     * Supprimer un Utilisateur
     * @Route("/utilisateur/supprimer/{id}/{route}", name="supprimer_utilisateur")
     */
    public function suppUtilisateur($route , $id, UtilisateurRepository $repository, Request $request){
        $utilisateur=$repository->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        if($route == 'admin_utilisateurs' ){
            return $this->redirectToRoute('admin_utilisateurs');
        }elseif ($route == 'admin_employees' ){
            return $this->redirectToRoute('admin_employees');
        }else{
            return $this->redirectToRoute('admin_admins');
        }

    }

    /**
     * Affichage de la liste des Equipes
     *
     * @Route("/equipes", name="equipes")
     */
    public function equipes(EquipeRepository $equipeRepository, Request $request){
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipeRepository->add($equipe);
            return $this->redirectToRoute('admin_equipes', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("admin/equipes.html.twig", [
            'equipes' => $equipeRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifier une Equipe
     * @Route("/equipe/modifier/{id}", name="modifier_equipe")
     */
    public function modifEqui( Equipe $equipe, Request $request){
        $form = $this -> createForm(EditEquipeType::class, $equipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /*$file = $Utilisateur->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){

            }
            $Utilisateur->setImage($fileName);*/
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('admin_equipes');
        }

        return $this->render('admin/editequipe.html.twig' , [
            'EquipeForm' => $form ->createView()
        ]);
    }

    /**
     * Supprimer une Equipe
     * @Route("/equipe/supprimer/{id}", name="supprimer_equipe")
     */
    public function suppEquip($id, EquipeRepository $repository ){
        $equipe=$repository->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($equipe);
        $entityManager->flush();

        return $this->redirectToRoute('admin_equipes');
    }

    /**
     * Recherche Utilisateur
     * @Route("/utilisateur/search", name="recherche_util")
     */
    public function recherche($id, EquipeRepository $repository ){
        $equipe=$repository->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($equipe);
        $entityManager->flush();

        return $this->redirectToRoute('admin_equipes');
    }
}
