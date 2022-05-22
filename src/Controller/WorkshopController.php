<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/workshop")
 */
class WorkshopController extends AbstractController
{
    /**
     * @Route("/", name="app_workshop")
     */
    public function index(WorkshopRepository $workshopRepository): Response
    {
        $workshops = $workshopRepository->findBy([], ['type' => 'ASC']);
        return $this->render('workshop/index.html.twig', [
            'workshops' => $workshops,
        ]);
    }

        /**
     * @Route("/add", name="app_workshop_add")
     */
    public function registration(Request $request, EntityManagerInterface $manager)
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($workshop);
            $manager->flush();
        }

        return $this->render('form/basic.html.twig', [
            'form' => $form->createView(),
            'title' => "Ajout d'un atelier",
            'anchor' => 'Valider'
        ]);
    }
}