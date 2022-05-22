<?php

namespace App\Controller;

use App\Entity\WorkshopChoice;
use App\Form\WorkshopChoiceType;
use App\Repository\WorkshopChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkshopChoiceController extends AbstractController
{
    /**
     * @Route("/workshop/choice", name="app_workshop_choice")
     */
    public function index(WorkshopChoiceRepository $workshopChoiceRepository): Response
    {
        return $this->render('workshop_choice/index.html.twig', [
            'workshopChoices' => $workshopChoiceRepository->findAll()
        ]);
    }

    /**
     * @Route("/wwadd", name="app_workshop_choice_add")
     */
    public function registration(Request $request, EntityManagerInterface $manager)
    {
        $workshop = new WorkshopChoice();
        $form = $this->createForm(WorkshopChoiceType::class, $workshop);

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

    /**
     * @Route("/workshop-data", name="workshop_data")
     */
    public function workshopData(Request $request, WorkshopChoiceRepository $workshopChoiceRepository)
    {

        $data = json_decode($request->getContent(), null, 512, JSON_THROW_ON_ERROR);

       $workshops = $workshopChoiceRepository->findWorkShopsByFilter($data->type, $data->weeks); 


        return new JsonResponse([
            'code' => 200,
            'message' => 'ok',
            'workshops' => $workshops
        ], 200);
        // }


    }
}