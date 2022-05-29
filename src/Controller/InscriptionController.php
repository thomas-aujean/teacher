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
     * @Route("/inscriptions-valide/{id}", name="inscription_validate")
     */
    public function validate(Request $request,  Inscription $inscription, ManagerRegistry $managerRegistry): Response
    {
        $workshops = $inscription->getWorkshopChoice()->getWorkshops();

        $em = $managerRegistry->getManager();
        foreach ($workshops as $workshop){
            $workshop->setEnroled($workshop->getEnroled() + 1);
        }

        $inscription->setStatus(Inscription::STATUS_VALIDATED);
        $em->flush();
        $this->addFlash('success', 'Le status a bien été modifié');


        return $this->redirectToRoute('app_inscriptions');
    }

    /**
     * @Route("/inscriptions-delete/{id}", name="inscription_delete")
     */
    public function delete(Request $request,  Inscription $inscription, ManagerRegistry $managerRegistry): Response
    {

        $inscription->setStatus(Inscription::STATUS_REMOVED);
        $em = $managerRegistry->getManager();
        $em->flush();
        $this->addFlash('success', 'La demande a bien été supprimée');


        return $this->redirectToRoute('app_inscriptions');
    }

    /**
     * @Route("/inscriptions-recues", name="app_inscriptions")
     */
    public function index(Request $request,  InscriptionRepository $inscriptionRepository): Response
    {
        $inscriptions = $inscriptionRepository->findBy(['status' => [
            Inscription::STATUS_PENDING,
            Inscription::STATUS_VALIDATED
        ]]);
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }
}