<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionController extends AbstractController
{
      /**
     * @Route("/inscription", name="app_inscription")
     */
    public function add(Request $request,  ManagerRegistry $managerRegistry): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($inscription);
            $em->persist($inscription->getContact());
            $em->flush();
            $this->addFlash('success', 'Votre demande a bien été reçue.');

            return $this->redirectToRoute("app_home");
        }
        return $this->render('inscription/add.html.twig', [
            'title' => "Demande d'inscription à un atelier",
            'form' => $form->createView(),
            'anchor' => 'Valider'
        ]);
    }

      /**
     * @Route("/inscriptions-recues", name="app_inscriptions")
     */
    public function index(Request $request,  InscriptionRepository $inscriptionRepository): Response
    {
        $inscriptions = $inscriptionRepository->findAll();
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }
}