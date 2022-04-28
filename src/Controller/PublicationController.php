<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\PubType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;

class PublicationController extends AbstractController
{
    /**###########################
     * <----Section Admin-------->
     */ ###########################

    /**
     * @Route("/getAll", name="app_pubb_index", methods={"GET"})
     */
    public function allPub(EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();
        return $this->render('pubb/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/admin/new", name="admin_pubb_new", methods={"GET", "POST"})
     */
    public function newA(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $publication->setDatePub(new \DateTime('now'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();
            return $this->redirectToRoute('Luser', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('pubb/newAdmin.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/show/{id}", name="app_pubb_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('pubb/show.html.twig', [
            'publication' => $publication,
        ]);
    }
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
    public function Luser(EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();
        return $this->render('publication/listPub_B.html.twig', [
            'controller_name' => 'PublicationController',
            'publications' => $publications,
        ]);
    }
    /**
     * @Route("/admin/{id}", name="Admin_Delete", methods={"POST"})
     */
    public function deleteA(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Luser', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/editA", name="admin_pubb_edit", methods={"GET", "POST"})
     */
    public function editA(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Luser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pubb/editAdmin.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }


    /**###########################
     * <------Section UI--------->
     */ ###########################


    /**
     * @Route("/publication",  name="app_pubb_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication/Blog.html.twig', [
            'publications' => $publications,
        ]);
    }



    /**
     * @Route("/{id}/edit", name="app_pubb_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pubb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pubb/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_pubb_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, PublicationRepository $rp): Response
    {
        $publication = new Publication();
        $publication->setDatePub(new \DateTime('now'));
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pubb/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="app_pubb_delete", methods={"POST"})
     */
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Luser', [], Response::HTTP_SEE_OTHER);
    }
}
